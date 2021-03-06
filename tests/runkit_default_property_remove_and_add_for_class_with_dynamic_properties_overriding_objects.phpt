--TEST--
runkit_default_property_remove() and runkit_default_property_add() functions on classes having dynamic properties (overriding objects)
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
	  if(!function_exists('runkit_default_property_add')) print "skip";
?>
--FILE--
<?php
class A {
	private $c = 1;
	public $d = 'd';
	public function getC() {return $this->c;}
}
class B extends A {}

$o = new B;
echo $o->getC(), "\n";
echo $o->b, $o->d, "\n";
$o->b = 'b';
echo $o->getC(), "\n";
echo $o->b, $o->d, "\n";
echo "remove\n";
runkit_default_property_remove('A', 'c', TRUE);
echo $o->getC(), "\n";
echo $o->b, $o->d, "\n";
echo "add public\n";
runkit_default_property_add('A', 'c', 2, RUNKIT7_OVERRIDE_OBJECTS);
echo $o->getC(), "\n";
echo $o->b, $o->d, "\n";
echo "remove\n";
runkit_default_property_remove('A', 'c', TRUE);
$o1 = new B;
echo $o1->getC(), "\n";
echo $o->getC(), "\n";
echo $o->b, $o->d, "\n";
echo "add private\n";
runkit_default_property_add('A', 'c', 3, RUNKIT7_ACC_PRIVATE | RUNKIT7_OVERRIDE_OBJECTS);
echo $o->getC(), "\n";
echo $o->b, $o->d, "\n";
echo "remove\n";
runkit_default_property_remove('A', 'c', TRUE);
echo $o->getC(), "\n";
echo $o->b, $o->d, "\n";
echo "add public to B\n";
runkit_default_property_add('B', 'c', 2, RUNKIT7_OVERRIDE_OBJECTS);
echo $o->getC(), "\n";
echo $o->b, $o->d, "\n";
--EXPECTF--
1

Notice: Undefined property: B::$b in %s on line %d
d
1
bd
remove

Notice: Undefined property: B::$c in %s on line %d

bd
add public
2
bd
remove

Notice: Undefined property: B::$c in %s on line %d


Notice: Undefined property: B::$c in %s on line %d

bd
add private
3
bd
remove

Notice: Undefined property: B::$c in %s on line %d

bd
add public to B
2
bd
