<?php


namespace models;


abstract class BaseModel {

	protected $tableName;

	abstract public function exec();
}