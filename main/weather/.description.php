<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Погода",
	"DESCRIPTION" => "Автоматический вывод погоды",
	"ICON" => "/images/catalog.gif",
	"COMPLEX" => "Y",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "content_1",
		"CHILD" => array(
			"ID" => "main_1222",
			"NAME" => "Мои компоненты",
			"SORT" => 30,
		)
	)
);
?>