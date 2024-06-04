<?php

use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;
use PhpCsFixerCustomFixers\Fixer as CustomFixer;
use PhpCsFixerCustomFixers\Fixers as CustomFixers;

$cwd = \getcwd();

if (\is_dir("{$cwd}/src") && (\is_dir("{$cwd}/public") || \is_dir("{$cwd}/web")))
{
	$dirs = [];

	// this is a symfony project, so add possible symfony directories
	// "custom" is a default directory of Shopware projects
	foreach (["app", "config", "custom", "public", "src", "tests", "web"] as $possibleDir)
	{
		if (\is_dir("{$cwd}/{$possibleDir}"))
		{
			$dirs[] = $possibleDir;
		}
	}
}
else
{
	// regular library, so just lint everything
	$dirs = ["src"];
}

$finder = PhpCsFixer\Finder::create()
	->in($dirs)
	->exclude([
		"Migrations",
		"node_modules",
		"secrets",
		"var",
		"vendor",
		"vendor-bin",
	])
	->ignoreUnreadableDirs();

$config = (new PhpCsFixer\Config())
	->setParallelConfig(ParallelConfigFactory::detect())
	->setIndent("\t")
	->setFinder($finder)
	->setRiskyAllowed(true)
	->registerCustomFixers(new CustomFixers())
	->setRules([
		//
		// These rules are sorted and grouped like the official docs:
		// https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst
		//
		// - every deprecated rule is excluded
		// - every experimental rule is excluded
		// - all other rules are included
		// - disabled rules are added commented out (with an optional reason under it)
		//
		// This ensures that we know that disabling a rule was a deliberate choice and not just
		// forgotten / overlooked.
		//
		// Last checked:
		//   friendsofphp/php-cs-fixer: v3.58
		//   kubawerlos/php-cs-fixer-custom-fixers: v3.21
		//

		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Rule Sets
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"@PSR1" => true,

		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Alias
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// "array_push" => false,
		"backtick_to_shell_exec" => true,
		"ereg_to_preg" => true,
		// "mb_str_functions" => false,
		"modernize_strpos" => true,
		"no_alias_functions" => [
			"sets" => ["@all"],
		],
		"no_alias_language_construct_call" => true,
		"no_mixed_echo_print" => [
			"use" => "echo",
		],
		"pow_to_exponentiation" => true,
		"random_api_migration" => true,
		"set_type_to_cast" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Array Notation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"array_syntax" => [
			"syntax" => "short",
		],
		"no_multiline_whitespace_around_double_arrow" => true,
		"no_whitespace_before_comma_in_array" => true,
		"normalize_index_brace" => true,
		// "return_to_yield_from" => false,
		"trim_array_spaces" => true,
		"whitespace_after_comma_in_array" => true,
		// "yield_from_array_to_yields" => false,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Attribute Notation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"attribute_empty_parentheses" => true,
		// "ordered_attributes" => false,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Basic
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// "braces_position" => [
		// 	"allow_single_line_anonymous_functions" => true,
		// 	"allow_single_line_empty_anonymous_classes" => true,
		// 	"anonymous_classes_opening_brace" => "next_line_unless_newline_at_signature_end",
		// 	"anonymous_functions_opening_brace" => "next_line_unless_newline_at_signature_end",
		// 	"classes_opening_brace" => "next_line_unless_newline_at_signature_end",
		// 	"control_structures_opening_brace" => "next_line_unless_newline_at_signature_end",
		// 	"functions_opening_brace" => "next_line_unless_newline_at_signature_end",
		//],
		//  └> unfortunately, this still breaks curly braces in method declarations: they stay on the same line
		"encoding" => true,
		"no_multiple_statements_per_line" => true,
		"no_trailing_comma_in_singleline" => true,
		"non_printable_character" => [
			"use_escape_sequences_in_strings" => true,
		],
		// "numeric_literal_separator" => false,
		//  └> the dev should be able to decide
		"octal_notation" => true,
		"psr_autoloading" => true,
		// "single_line_empty_body" => true,
		//  └> breaks for empty classes (moves the braces to the same line)


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Casing
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"class_reference_name_casing" => true,
		"constant_case" => [
			"case" => "lower",
		],
		"integer_literal_case" => true,
		"lowercase_keywords" => true,
		"lowercase_static_reference" => true,
		"magic_constant_casing" => true,
		"magic_method_casing" => true,
		"native_function_casing" => true,
		"native_function_type_declaration_casing" => true,
		"native_type_declaration_casing" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Cast
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"cast_spaces" => [
			"space" => "single",
		],
		"lowercase_cast" => true,
		"modernize_types_casting" => true,
		"no_short_bool_cast" => true,
		"no_unset_cast" => true,
		"short_scalar_cast" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Class Notation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// @todo not sure
		"class_attributes_separation" => [
			"elements" => [
				"const" => "only_if_meta",
				"method" => "one",
				"property" => "only_if_meta",
				"trait_import" => "only_if_meta",
				"case" => "only_if_meta",
			],
		],
		"class_definition" => true,
		// "final_class" => false,
		"final_internal_class" => true,
		// "final_public_method_for_abstract_class" => false,
		"no_blank_lines_after_class_opening" => true,
		"no_null_property_initialization" => true,
		"no_php4_constructor" => true,
		"no_unneeded_final_method" => true,
		"ordered_class_elements" => [
			// just traits at the top, the rest is fine
			"order" => ["use_trait"],
		],
		// "ordered_interfaces" => false,
		"ordered_traits" => true,
		"ordered_types" => [
			"sort_algorithm" => "none",
			"null_adjustment" => "always_last",
		],
		// "phpdoc_readonly_class_comment_to_keyword" => false,
		"protected_to_private" => true,
		"self_accessor" => true,
		"self_static_accessor" => true,
		"single_class_element_per_statement" => true,
		"single_trait_insert_per_statement" => true,
		"visibility_required" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Class Usage
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// "date_time_immutable" => false,
		//  └> you should always use immutables, but we don't want to automatically rewrite it


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Comment
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"comment_to_phpdoc" => true,
		// "header_comment" => false,
		"multiline_comment_opening_closing" => true,
		"no_empty_comment" => true,
		"no_trailing_whitespace_in_comment" => true,
		"single_line_comment_spacing" => true,
		"single_line_comment_style" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Class Usage
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"native_constant_invocation" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Control Structure
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"control_structure_braces" => true,
		"control_structure_continuation_position" => [
			"position" => "next_line",
		],
		"elseif" => true,
		"empty_loop_body" => [
			"style" => "semicolon",
		],
		"empty_loop_condition" => [
			"style" => "while",
		],
		"include" => true,
		"no_alternative_syntax" => true,
		"no_break_comment" => true,
		"no_superfluous_elseif" => true,
		"no_unneeded_braces" => true,
		"no_unneeded_control_parentheses" => true,
		"no_useless_else" => true,
		"simplified_if_return" => true,
		"switch_case_semicolon_to_colon" => true,
		"switch_case_space" => true,
		"switch_continue_to_break" => true,
		"trailing_comma_in_multiline" => [
			"after_heredoc" => true,
			"elements" => [
				"arguments",
				"arrays",
				"match",
				"parameters",
			],
		],
		"yoda_style" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Doctrine Annotation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"doctrine_annotation_array_assignment" => true,
		// "doctrine_annotation_braces" => false,
		"doctrine_annotation_indentation" => true,
		"doctrine_annotation_spaces" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Function Notation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"combine_nested_dirname" => true,
		"date_time_create_from_format_call" => true,
		// "fopen_flag_order" => false,
		// "fopen_flags" => false,
		//"function_declaration" => [
		//	"closure_fn_spacing" => "one",
		//	"closure_function_spacing" => "one",
		//	"trailing_comma_single_line" => false,
		//],
		"implode_call" => true,
		"lambda_not_used_import" => true,
		"method_argument_space" => [
			"after_heredoc" => true,
			"attribute_placement" => "standalone",
			"keep_multiple_spaces_after_comma" => false,
			"on_multiline" => "ensure_fully_multiline",
		],
		"native_function_invocation" => [
			"include" => ["@compiler_optimized"],
			"scope" => "namespaced",
			"strict" => true,
		],
		"no_spaces_after_function_name" => true,
		// "no_unreachable_default_argument_value" => false,
		//  └> checked by PhpStan
		"no_useless_sprintf" => true,
		"nullable_type_declaration_for_default_null_value" => true,
		// "regular_callable_call" => false,
		"return_type_declaration" => [
			"space_before" => "one",
		],
		// "single_line_throw" => false,
		"static_lambda" => true,
		"use_arrow_functions" => true,
		"void_return" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Import
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"fully_qualified_strict_types" => true,
		"global_namespace_import" => [
			"import_classes" => false,
			"import_constants" => false,
			"import_functions" => false,
		],
		// "group_import" => false,
		"no_leading_import_slash" => true,
		"no_unneeded_import_alias" => true,
		"no_unused_imports" => true,
		"ordered_imports" => [
			"imports_order" => [
				"class",
				"function",
				"const",
			],
			"sort_algorithm" => "alpha",
		],
		"single_import_per_statement" => true,
		"single_line_after_imports" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Language Construct
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"combine_consecutive_issets" => true,
		"combine_consecutive_unsets" => true,
		"declare_equal_normalize" => [
			"space" => "none",
		],
		"declare_parentheses" => true,
		"dir_constant" => true,
		"error_suppression" => true,
		"explicit_indirect_variable" => true,
		"function_to_constant" => true,
		"get_class_to_class_keyword" => true,
		"is_null" => true,
		"no_unset_on_property" => true,
		"nullable_type_declaration" => [
			"syntax" => "question_mark",
		],
		// this breaks spaces placement for `try {`
		// "single_space_around_construct" => false,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// List Notation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"list_syntax" => [
			"syntax" => "short",
		],


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Namespace Notation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"blank_line_after_namespace" => true,
		"blank_lines_before_namespace" => true,
		"clean_namespace" => true,
		"no_leading_namespace_whitespace" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Naming
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"no_homoglyph_names" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Operator
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"assign_null_coalescing_to_coalesce_equal" => true,
		"binary_operator_spaces" => true,
		"concat_space" => [
			"spacing" => "one",
		],
		"increment_style" => true,
		"logical_operators" => true,
		"long_to_shorthand_operator" => true,
		"new_with_parentheses" => true,
		"no_space_around_double_colon" => true,
		"no_useless_concat_operator" => true,
		"no_useless_nullsafe_operator" => true,
		// "not_operator_with_space" => false,
		// "not_operator_with_successor_space" => false,
		"object_operator_without_whitespace" => true,
		"operator_linebreak" => [
			"only_booleans" => false,
			"position" => "beginning",
		],
		"standardize_increment" => true,
		"standardize_not_equals" => true,
		"ternary_operator_spaces" => true,
		"ternary_to_elvis_operator" => true,
		"ternary_to_null_coalescing" => true,
		"unary_operator_spaces" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// PHP Tag
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"blank_line_after_opening_tag" => true,
		"echo_tag_syntax" => [
			"format" => "short",
			"shorten_simple_statements_only" => true,
		],
		"full_opening_tag" => true,
		"linebreak_after_opening_tag" => true,
		"no_closing_tag" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// PHPUnit
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// "php_unit_attributes" => true,
		//  └> we can't fully update to newer PHPUnit versions yet
		"php_unit_construct" => true,
		"php_unit_data_provider_name" => [
			"prefix" => "provide",
			"suffix" => "",
		],
		"php_unit_data_provider_return_type" => true,
		"php_unit_data_provider_static" => true,
		"php_unit_dedicate_assert" => true,
		"php_unit_dedicate_assert_internal_type" => true,
		"php_unit_expectation" => true,
		"php_unit_fqcn_annotation" => true,
		"php_unit_internal_class" => true,
		"php_unit_method_casing" => true,
		"php_unit_mock" => true,
		"php_unit_mock_short_will_return" => true,
		"php_unit_namespaced" => true,
		"php_unit_no_expectation_annotation" => true,
		"php_unit_set_up_tear_down_visibility" => true,
		// "php_unit_size_class" => false,
		"php_unit_strict" => true,
		"php_unit_test_annotation" => [
			"style" => "prefix",
		],
		"php_unit_test_case_static_method_calls" => true,
		// "php_unit_test_class_requires_covers" => false,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// PHPDoc
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"align_multiline_comment" => [
			"comment_type" => "phpdocs_only",
		],
		// "general_phpdoc_annotation_remove" => false,
		// "general_phpdoc_tag_rename" => false,
		"no_blank_lines_after_phpdoc" => true,
		// "no_empty_phpdoc" => false,
		"no_superfluous_phpdoc_tags" => [
			"allow_hidden_params" => true,
			"remove_inheritdoc" => false,
		],
		// "phpdoc_add_missing_param_annotation" => false,
		"phpdoc_align" => true,
		"phpdoc_annotation_without_dot" => true,
		// "phpdoc_array_type" => false,
		"phpdoc_indent" => true,
		"phpdoc_inline_tag_normalizer" => true,
		// "phpdoc_line_span" => false,
		"phpdoc_list_type" => true,
		"phpdoc_no_access" => true,
		"phpdoc_no_alias_tag" => true,
		"phpdoc_no_empty_return" => true,
		"phpdoc_no_package" => true,
		"phpdoc_no_useless_inheritdoc" => true,
		// "phpdoc_order_by_value" => false,
		"phpdoc_order" => [
			"order" => [
				"param",
				"return",
				"throws",
			],
		],
		"phpdoc_param_order" => true,
		"phpdoc_return_self_reference" => true,
		"phpdoc_scalar" => true,
		"phpdoc_separation" => [
			// use Symfony's config
			"groups" => [
				["Annotation", "NamedArgumentConstructor", "Target"],
				["author", "copyright", "license"],
				["category", "package", "subpackage"],
				["property", "property-read", "property-write"],
				["deprecated", "link", "see", "since"],
			],
		],
		"phpdoc_single_line_var_spacing" => true,
		// "phpdoc_summary" => false,
		// "phpdoc_tag_casing" => false,
		// "phpdoc_tag_type" => false,
		"phpdoc_to_comment" => true,
		"phpdoc_trim_consecutive_blank_line_separation" => true,
		"phpdoc_trim" => true,
		"phpdoc_types" => true,
		"phpdoc_types_order" => [
			"null_adjustment" => "always_last",
			"sort_algorithm" => "none",
		],
		"phpdoc_var_annotation_correct_order" => true,
		"phpdoc_var_without_name" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Return Notation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"no_useless_return" => true,
		// "return_assignment" => false,
		"simplified_null_return" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Semicolon
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"multiline_whitespace_before_semicolons" => true,
		"no_empty_statement" => true,
		"no_singleline_whitespace_before_semicolons" => true,
		"semicolon_after_instruction" => true,
		"space_after_semicolon" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Strict
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"declare_strict_types" => true,
		"strict_comparison" => true,
		"strict_param" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// String Notation
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"explicit_string_variable" => true,
		// "heredoc_closing_marker" => false,
		"heredoc_to_nowdoc" => true,
		// "multiline_string_to_heredoc" => false,
		"no_binary_string" => true,
		// "no_trailing_whitespace_in_string" => false,
		"simple_to_complex_string_variable" => true,
		// "single_quote" => false,
		// "string_implicit_backslashes" => false,
		// "string_length_to_empty" => false,
		"string_line_ending" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Whitespace
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		"array_indentation" => true,
		"blank_line_before_statement" => [
			"statements" => [
				"case",
				"default",
				"do",
				"exit",
				"for",
				"foreach",
				"if",
				"return",
				"switch",
				"try",
				"while",
			],
		],
		"blank_line_between_import_groups" => true,
		"compact_nullable_type_declaration" => true,
		"heredoc_indentation" => true,
		"indentation_type" => true,
		"line_ending" => true,
		"method_chaining_indentation" => true,
		"no_extra_blank_lines" => [
			"tokens" => [
				"attribute",
				"case",
				"continue",
				"curly_brace_block",
				"default",
				"extra",
				"parenthesis_brace_block",
				"return",
				"square_brace_block",
				"switch",
				"throw",
				"use",
			],
		],
		"no_spaces_around_offset" => true,
		"no_trailing_whitespace" => true,
		"no_whitespace_in_blank_line" => true,
		"single_blank_line_at_eof" => true,
		"spaces_inside_parentheses" => [
			"space" => "none",
		],
		"statement_indentation" => [
			"stick_comment_to_next_continuous_control_statement" => true,
		],
		"type_declaration_spaces" => true,
		"types_spaces" => true,


		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// Custom Fixers from kubawerlos/php-cs-fixer-custom-fixers
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		CustomFixer\CommentSurroundedBySpacesFixer::name() => true,
		CustomFixer\DeclareAfterOpeningTagFixer::name() => true,
		CustomFixer\EmptyFunctionBodyFixer::name() => true,
		CustomFixer\MultilineCommentOpeningClosingAloneFixer::name() => true,
		CustomFixer\MultilinePromotedPropertiesFixer::name() => true,
		CustomFixer\NoDoctrineMigrationsGeneratedCommentFixer::name() => true,
		CustomFixer\NoDuplicatedArrayKeyFixer::name() => true,
		CustomFixer\NoDuplicatedImportsFixer::name() => true,
		CustomFixer\NoImportFromGlobalNamespaceFixer::name() => true,
		CustomFixer\NoSuperfluousConcatenationFixer::name() => true,
		CustomFixer\NoTrailingCommaInSinglelineFixer::name() => true,
		CustomFixer\NoUselessParenthesisFixer::name() => true,
		CustomFixer\NoUselessStrlenFixer::name() => true,
		CustomFixer\PhpUnitAssertArgumentsOrderFixer::name() => true,
		CustomFixer\PhpUnitDedicatedAssertFixer::name() => true,
		CustomFixer\PhpUnitNoUselessReturnFixer::name() => true,
		CustomFixer\PhpdocNoSuperfluousParamFixer::name() => true,
		CustomFixer\PhpdocParamTypeFixer::name() => true,
		CustomFixer\PhpdocSelfAccessorFixer::name() => true,
		CustomFixer\PhpdocSingleLineVarFixer::name() => true,
		CustomFixer\PhpdocTypesCommaSpacesFixer::name() => true,
		CustomFixer\PhpdocTypesTrimFixer::name() => true,
		CustomFixer\PhpdocVarAnnotationToAssertFixer::name() => true,
		CustomFixer\SingleSpaceBeforeStatementFixer::name() => true,
		CustomFixer\StringableInterfaceFixer::name() => true,
	]);


return $config;
