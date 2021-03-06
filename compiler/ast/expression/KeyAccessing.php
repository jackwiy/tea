<?php
/**
 * This file is part of the Tea programming language project
 *
 * @author 		Benny <benny@meetdreams.com>
 * @copyright 	(c)2019 YJ Technology Ltd. [http://tealang.org]
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Tea;

class KeyAccessing extends Node implements IExpression, IAssignable
{
	const KIND = 'key_accessing';

	public $left;
	public $right;

	public function __construct(IExpression $left, IExpression $right)
	{
		$this->left = $left;
		$this->right = $right;
	}
}

