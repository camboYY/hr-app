import vue from "@vitejs/plugin-vue"; //add this line
import laravel from "laravel-vite-plugin";
import path from "path";
import { defineConfig } from "vite";
export default defineConfig({
    plugins: [
        laravel(["resources/js/app.js"]),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,

                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directory as expected.
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: [
            {
                find: "@",
                replacement: path.resolve(__dirname, "./resources/js/"),
            },
        ],
    },
});
