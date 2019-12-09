<?php
namespace tea\tests\syntax;

use tea\tests\xview\{ BaseView, IViewDemo };
use tea\tests\PHPDemoUnit\{ BaseInterface, NS1\Demo as PHPClassDemo, const PHP_CONST_DEMO, function php_function_demo };

const UNIT_PATH = __DIR__ . DIRECTORY_SEPARATOR;

$super_path = dirname(__DIR__, 4) . DIRECTORY_SEPARATOR; // the workspace/vendor path
require_once $super_path . 'tea/dist/builtin/__unit.php'; // the builtins
require_once $super_path . 'tea/dist/tests/xview/__unit.php';
require_once $super_path . 'tea/tests/PHPDemoUnit/__unit.php';

/*internal*/	const PI = 3.1415926;


function new_collector_demo(): CollectorDemo
{
	return new CollectorDemo();
}

function collector1(): array
{
	$__collects = [];
	$__collects[] = '<div>hei~</div>';

	new CollectorDemo();

	(new CollectorDemo())->subnode->text('red')->subnode = new_collector_demo();

	$abc = new CollectorDemo();

	$factory = new CollectorDemoFactory();

	new_collector_demo();
	$factory->new_collector_demo();

	if (1) {
		(new CollectorDemo())->text('red')->subnode->text('hei~');
	}

	foreach ([1, 2, 3] as $item) {
		(new CollectorDemo())->subnode->text('hello');
	}

	return $__collects;
}

function xrange(int $start, int $stop, int $step = 1)
{
	$i = null;

	if ($step > 0) {
		$i = $start;
		while ($i < $stop) {
			yield $i;
			$i += $step;
		}

		return;
	}

	if ($step == 0) {
		throw new Exception('Step should not be 0.');
	}

	$i = $start;
	while ($i > $stop) {
		yield $i;
		$i += $step;
	}
}

function get_class(): string
{
	return Test1::class;
}

function fn0($str)
{
	echo $str, NL;
}

function fn1(callable $callee)
{
	$unknow_type_value = $callee('hei');
}

function fn2(string $class)
{
	$class();
}

function fn3(\Exception $ex, string $num = null)
{
	$num = 1;
	echo $ex->getMessage(), NL;
}


// program end

# --- generates ---
const __AUTOLOADS = [
	'tea\tests\syntax\CollectorDemo' => 'type-collector.php',
	'tea\tests\syntax\CollectorDemoFactory' => 'type-collector.php',
	'tea\tests\syntax\TeaDemoClass' => 'main1.php',
	'tea\tests\syntax\Cell' => 'type-xview.php',
	'tea\tests\syntax\DemoList' => 'type-xview.php',
	'tea\tests\syntax\IDemo' => 'class.php',
	'tea\tests\syntax\IDemoTrait' => 'class.php',
	'tea\tests\syntax\BaseClass' => 'class.php',
	'tea\tests\syntax\Test1' => 'class.php',
	'tea\tests\syntax\Test2' => 'class.php',
	'tea\tests\syntax\ITest' => 'class.php',
	'tea\tests\syntax\Test3' => 'class.php',
	'tea\tests\syntax\Test4' => 'class.php',
	'tea\tests\syntax\Test5' => 'class.php'
];

spl_autoload_register(function ($class) {
	isset(__AUTOLOADS[$class]) && require UNIT_PATH . __AUTOLOADS[$class];
});

// end