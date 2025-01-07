import globals from "globals";
import pluginJs from "@eslint/js";
import tseslint from "typescript-eslint";
import pluginVue from "eslint-plugin-vue";
import eslintConfigPrettier from "eslint-config-prettier";


/** @type {import('eslint').Linter.Config[]} */
export default [
    {files: ["**/*.{js,mjs,cjs,ts,vue}"]},
    {languageOptions: {globals: globals.browser}},
    pluginJs.configs.recommended,
    ...tseslint.configs.recommended,
    ...pluginVue.configs["flat/essential"],
    eslintConfigPrettier,
    {
        files: ["**/*.vue", "**/*.js"],
        languageOptions: {parserOptions: {parser: tseslint.parser}},
    },
    {
        files: ["app.vue", "error.vue", "pages/**/*.vue", "layouts/**/*.vue"],
        rules: {
            // disable the rule for these files
            "vue/multi-word-component-names": "off",
        },
    },
    {
        ignores: [
            "node_modules/*",
            "vendor/*",
            "public/*",
        ]
    }
];
