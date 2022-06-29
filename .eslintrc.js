module.exports = {
	'env': {
		'browser': true,
		'es2021': true
	},
	'extends': [
		'eslint:recommended',
		'plugin:vue/essential'
	],
	'parserOptions': {
		'ecmaVersion': 'latest'
	},
	'plugins': [
		'vue'
	],
	'rules': {
		'indent': [
			'error',
			2
		],
		'vue/script-indent': ["error", 2, { "baseIndent": 0 }],
		'linebreak-style': [
			'error',
			'unix'
		],
		'quotes': [
			'error',
			'single'
		],
		'semi': 'off',
		'vue/no-multiple-template-root': 'off'
	}
};
