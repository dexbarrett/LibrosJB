<?php
function sortBooksBy($linkText, $column, $direction)
{
    $pageNumber = request()->input('page');
    $direction = (request()->route('direction') == 'asc') ? 'desc' : 'asc';

    return link_to_action('BookController@index', $linkText, [
        'sortBy' => $column, 'direction' => $direction, 'page' => $pageNumber
        ]);
}

function mapFieldToDBColumn($field)
{
    $FieldColumnMap = [
        'titulo' => 'books.title',
        'autor'  => 'authors.name',
        'precio' => 'books.sale_price'
    ];

    if (array_key_exists($field, $FieldColumnMap)) {
        return $FieldColumnMap[$field];
    }
}

function pluralize($word, $number)
{
    $words = [
        'mensaje' => 'mensajes'
    ];

    if ($number == 1) {
        return $word;
    }

    return $words[$word];
}

function getConversationIcon($bookForSale, $unreadMessages) {
    $iconClass = ($unreadMessages > 0)? 'commenting': 'comment';
    
    if ($bookForSale) {
        $iconClass .= '-o';
    }

    return 'fa-' . $iconClass;
}