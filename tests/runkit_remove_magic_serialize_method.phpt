--TEST--
removing magic serialize method
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip";
?>
--FILE--
<?php
class Test implements Serializable {
	function serialize() {}
	function unserialize($s) {}
}

$a = new Test();
runkit_method_remove("Test", "serialize");
$s1 = serialize($a);
?>
--EXPECTF--
Fatal error: Couldn't find implementation for method Test::serialize in Unknown on line %d
