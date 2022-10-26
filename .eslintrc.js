module.exports = {
    root: true,
    env: {
        node: true,
        browser: true,
    },
    extends: [
        'eslint:recommended',
        'eslint-config-prettier',
        'prettier',
    ],
    plugins: [
        'eslint-plugin-prettier',
    ],
    parserOptions: {
        parser: '@babel/eslint-parser',
        sourceType: 'module',
        ecmaVersion: 2017,
        requireConfigFile: false,
    },
    rules: {
        'prettier/prettier': [
            'warn',
            {
                printWidth: 120,
                bracketSpacing: false,
                singleQuote: true,
                semi: true,
                endOfLine: 'lf',
                arrowParens: 'always',
                trailingComma: 'es5',
            },
        ],
        'no-constant-condition': [
            'error',
            {
                checkLoops: false,
            },
        ],
        'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        quotes: [
            'warn',
            'single',
            {
                avoidEscape: true,
                allowTemplateLiterals: true,
            },
        ],
    },
    globals: {
        axios: 'readonly',
        Bootstrap: 'readonly',
    },
};
