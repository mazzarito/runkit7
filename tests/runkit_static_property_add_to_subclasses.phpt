--TEST--
runkit_static_property_add() add properties to subclasses
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
      if(!function_exists('runkit_default_property_add')) print "skip";
?>
--INI--
error_reporting=E_ALL
display_errors=on
--FILE--
<?php
class RunkitClass {
	public static function setPrivate() {self::$privateProperty = "b";}
	public static function setProtected() {self::$protectedProperty = 1;}
}

class RunkitSubClass extends RunkitClass {
	public static function getPrivate() {return self::$privateProperty;}
	public static function getProtected() {return self::$protectedProperty;}
}
class StdSubClass extends stdClass {}

$className = 'RunkitClass';
$propName = 'publicProperty';
$value = 1;
runkit_default_property_add($className, 'constArray', array('a'=>1), RUNKIT7_ACC_STATIC);
runkit_default_property_add($className, $propName, $value, RUNKIT7_ACC_PUBLIC | RUNKIT7_ACC_STATIC);
runkit_default_property_add($className, 'privateProperty', "a", RUNKIT7_ACC_PRIVATE | RUNKIT7_ACC_STATIC);
runkit_default_property_add($className, 'protectedProperty', NULL, RUNKIT7_ACC_PROTECTED | RUNKIT7_ACC_STATIC);
$obj = new RunkitSubClass;
runkit_default_property_add($className, 'dynamic', $obj, RUNKIT7_ACC_STATIC);
$value = 10;

RunkitClass::$constArray = array('b'=>2);
RunkitClass::$publicProperty = 2;
RunkitClass::setPrivate();
RunkitClass::setProtected();
RunkitClass::$dynamic = new RunkitClass;

print_r(RunkitSubClass::$constArray);
echo $propName, "\n";
var_dump(RunkitSubClass::$publicProperty);
var_dump(RunkitSubClass::getProtected());
var_dump(RunkitSubClass::$dynamic);

runkit_default_property_add('StdSubClass', 'str', 'test', RUNKIT7_ACC_STATIC);

var_dump(StdSubClass::$str);
var_dump(RunkitSubClass::getPrivate());
?>
--EXPECTF--
Array
(
    [b] => 2
)
publicProperty
int(2)
int(1)
object(RunkitClass)#2 (0) {
}
string(4) "test"

Fatal error: Access to undeclared static property: RunkitSubClass::$privateProperty in %s on line %d
