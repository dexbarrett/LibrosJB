<?php
namespace LibrosJB\Services\Validation;

class BookFormValidator extends FormValidator
{
    protected $rules = [

        'create' => [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'edition' => 'required|integer',
            'edition_year' => 'required|integer',
            'pages' => 'required|integer',
            'extract' => 'required|min:20',
            'cover' => 'required|mimes:jpeg,gif,png',
            'condition' => 'required|integer',
            'price' => 'required|integer',
            'comments' => 'min:10'
        ],

        'update' => [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'edition' => 'required|integer',
            'edition_year' => 'required|integer',
            'pages' => 'required|integer',
            'extract' => 'required|min:20',
            'condition' => 'required|integer',
            'price' => 'required|integer',
            'comments' => 'min:10'
        ]
    ];

    protected $friendlyNames = [
        'title' => 'Título',
        'author' => 'Autor',
        'publisher' => 'Editorial',
        'edition' => 'Edición',
        'edition_year' => 'Año de la edición',
        'pages' => 'No. de páginas',
        'extract' => 'sinopsis',
        'cover' => 'imagen de portada',
        'condition' => 'Condición',
        'price' => 'precio de venta',
        'comments' => 'comentarios'
    ];
}   