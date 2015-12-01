<?php
namespace LibrosJB\Services\Validation;

class BookFormValidator extends FormValidator
{
    protected $rules = [

        'create' => [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'language' => 'required|integer|exists:languages,id',
            'edition_year' => 'required|integer|digits:4',
            'pages' => 'required|integer',
            'extract' => 'required|min:20',
            'cover' => 'required|mimes:jpeg,gif,png',
            'condition' => 'required|integer|exists:book_conditions,id',
            'price' => 'required|integer',
            'comments' => 'min:10'
        ],

        'update' => [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'language' => 'required|integer|exists:languages,id',
            'edition_year' => 'required|integer',
            'pages' => 'required|integer',
            'extract' => 'required|min:20',
            'condition' => 'required|integer|exists:book_conditions,id',
            'price' => 'required|integer',
            'comments' => 'min:10'
        ]
    ];

    protected $friendlyNames = [
        'title' => 'Título',
        'author' => 'Autor',
        'publisher' => 'Editorial',
        'language' => 'Idioma',
        'edition_year' => 'Año de la edición',
        'pages' => 'No. de páginas',
        'extract' => 'sinopsis',
        'cover' => 'imagen de portada',
        'condition' => 'Condición',
        'price' => 'precio de venta',
        'comments' => 'comentarios'
    ];

    protected function getConditionalRules()
    {
        return [
            'create' => $this->getConditionalRulesForCreation(),
            'update' => $this->getConditionalRulesForUpdating()        
        ];
    }

    protected function getConditionalRulesForCreation()
    {
       return [
            'author' => [
                'rules'     => 'exists:authors,id',
                'condition' => function(){ return intval($this->getFieldValue('author')) > 0; }
            ],

            'publisher' => [
                'rules'     => 'exists:publishers,id',
                'condition' => function(){ return intval($this->getFieldValue('publisher')) > 0; }
            ]
        ];       
    }

    protected function getConditionalRulesForUpdating()
    {
        return $this->getConditionalRulesForCreation();
    }
}   