<?php
/**
 * This file is part of the Tea programming language project
 *
 * @author 		Benny <benny@meetdreams.com>
 * @copyright 	(c)2019 YJ Technology Ltd. [http://tealang.org]
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Tea;

TeaHelper::$NORMAL_RESERVEDS = array_merge(
	TypeFactory::BUILTIN_TYPE_NAMES,
	TeaHelper::STRUCTURE_KEYS,
	TeaHelper::MODIFIERS,
	TeaHelper::BUILTIN_IDENTIFIERS,
	TeaHelper::OTHER_RESERVEDS
);

class TeaHelper
{
	const PATTERN_MODIFIER_REGEX = '/[imu]+/';

	const STRUCTURE_KEYS = [
		_VAR,
		_IF, _WHEN, _FOR, _WHILE, _TRY, // _LOOP
		_ECHO, _PRINT, _RETURN, _EXIT, _BREAK, _CONTINUE, _THROW,
	];

	const MODIFIERS = [
		_MASKED,
		_PUBLIC,
		_INTERNAL,
		_PROTECTED,
		_PRIVATE
	];

	const BUILTIN_IDENTIFIERS = [_THIS, _SUPER, _VAL_NONE, _VAL_TRUE, _VAL_FALSE, _UNIT_PATH];

	const OTHER_RESERVEDS = [
		_CONSTRUCT, _DESTRUCT, _STATIC,
		_ELSEIF, _ELSE, _CATCH, _FINALLY,
		_WHEN,
	];

	const ASSIGN_OPERATORS = [_ASSIGN, '.=', '**=', '+=', '-=', '*=', '/=', '%=', '&=', '|=', '^=', '<<=', '>>=']; // '??='

	static $NORMAL_RESERVEDS;

	/**
	 * Check token is a number
	 * and return the number base type when is a number format
	 *
	 * @return string 	the number base type (_BASE_DECIMAL, _BASE_HEX, _BASE_OCTAL, _BASE_BINARY)
	 */
	static function check_number($token)
	{
		if ($token === _ZERO || preg_match('/^[1-9][0-9_]*(e\+?[0-9]*)?$/i', $token)) {
			return _BASE_DECIMAL;
		}

		if ($token[0] === _ZERO) {
			if ($token[1] === _BASE_HEX) {
				return preg_match('/^0x[0-9a-f][0-9a-f_]*$/i', $token) ? _BASE_HEX : null;
			}
			elseif ($token[1] === _BASE_BINARY) {
				return preg_match('/^0b[01][01_]*$/', $token) ? _BASE_BINARY : null;
			}
			elseif ($token[1] === _BASE_OCTAL) {
				return preg_match('/^0o[0-7][0-7_]*$/', $token) ? _BASE_OCTAL : null;
			}
		}

		return null;
	}

	static function is_uint_number($token)
	{
		return preg_match('/^[1-9][0-9]*$/', $token) && $token <= PHP_INT_MAX;
	}

	static function is_space_tab($token)
	{
		return $token === _SPACE || $token === _TAB;
	}

	static function is_space_tab_nl($token)
	{
		return $token === _SPACE || $token === _TAB || $token === LF || $token === _CR;
	}

	static function is_normal_reserveds($token)
	{
		return in_array(strtolower($token), self::$NORMAL_RESERVEDS, true);
	}

	static function is_modifier($token)
	{
		return in_array($token, self::MODIFIERS, true);
	}

	static function is_structure_key($token)
	{
		return in_array($token, self::STRUCTURE_KEYS, true);
	}

	static function is_builtin_identifier($token)
	{
		return in_array($token, self::BUILTIN_IDENTIFIERS, true);
	}

	static function is_xtag_name($token)
	{
		return preg_match('/^[a-z\-\!][a-z0-9\-:]*$/i', $token);
	}

	static function is_identifier_name(?string $token)
	{
		return preg_match('/^_*[a-z][a-z0-9_]*$/i', $token);
	}

	static function is_declarable_variable_name(?string $token)
	{
		return preg_match('/^_?[a-z][a-z0-9_]*$/', $token) && !TeaHelper::is_normal_reserveds($token);
	}

	static function is_constant_name(?string $token)
	{
		return preg_match('/^_*[A-Z][A-Z0-9_]+$/', $token);
	}

	static function is_function_name(?string $token)
	{
		return preg_match('/^_?[a-z][a-z0-9_]*$/', $token);
	}

	static function is_strict_less_function_name(?string $token)
	{
		return preg_match('/^[_a-z]+[a-zA-Z0-9_]*$/', $token);
	}

	static function is_classlike_name(?string $token)
	{
		return preg_match('/^[A-Z][a-zA-Z0-9_]*$/', $token);
	}

	static function is_interface_marked_name(string $name)
	{
		return ($name[0] === 'I' && preg_match('/^I[A-Z]/', $name)) || substr($name, -9) === 'Interface';
	}

	static function is_type_name(?string $token)
	{
		return self::is_builtin_type_name($token) || self::is_classlike_name($token);
	}

	static function is_builtin_type_name(?string $token)
	{
		return in_array($token, TypeFactory::BUILTIN_TYPE_NAMES, true);
	}

	static function is_domain_component(?string $token)
	{
		return preg_match('/^[a-z][a-z0-9\-]*[a-z0-9]$/i', $token);
	}

	static function is_subnamespace_name(?string $token)
	{
		return preg_match('/^[a-z][a-z0-9]+$/i', $token);
	}

	static function is_assign_operator(?string $token)
	{
		return in_array($token, self::ASSIGN_OPERATORS, true);
	}

	static function is_regex_flags($token)
	{
		return preg_match(self::PATTERN_MODIFIER_REGEX, $token);
	}
}
