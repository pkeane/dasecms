<?php


//from http://richard.gluga.com/2010/08/awesome-php-53-array-multi-sort.html
//changed from array sort to obj sort
//requires php 5.3

function multiSort($data, $field) {
		if (!is_array($field)) {    //if the field is given as a string, assume ascending
				$field = array($field=>true);
		}
		usort($data, function($a, $b) use($field) {
				$retval = 0;
				foreach ($field as $fieldname=>$asc) {
						if ($retval == 0) {
								$retval = strnatcmp($a->$fieldname, $b->$fieldname);
								if(!$asc) $retval *= -1;    //if
						}
				}
				return $retval;
		});
		return $data;
}

class Book {
		public $author_first;
		public $author_last;
		public $publisher;
}

$books = array();

$book1 = new Book();
$book1->author_first = 'John';
$book1->author_last = 'Smith';
$book1->publisher = 'Arcade';
$books[] = $book1;

$book2 = new Book();
$book2->author_first = 'Sally';
$book2->author_last = 'Smith';
$book2->publisher = 'Arcade';
$books[] = $book2;

$book3 = new Book();
$book3->author_first = 'John';
$book3->author_last = 'Smith';
$book3->publisher = 'Genome';
$books[] = $book3;

$book4 = new Book();
$book4->author_first = 'John';
$book4->author_last = 'Smith';
$book4->publisher = 'Radius';
$books[] = $book4;

$book5 = new Book();
$book5->author_first = 'Andrea';
$book5->author_last = 'Smith';
$book5->publisher = 'Arcade';
$books[] = $book5;


$fields = array(
		'publisher' => true,
		'author_last' => true,
		'author_first' => true,
);


print_r(multiSort($books,$fields));
