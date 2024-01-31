import fs from 'fs';
import laravel from 'laravel-vite-plugin'
import {defineConfig} from 'vite'
import {resolve} from 'path'

let host = 'ecommerce-starter.dev';

export default defineConfig({
    server: detectServerConfig(host),
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/app.js',
                'resources/scss/admin.scss',
                'resources/js/admin.js',
            ],
            publicDirectory:'public',
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js'
        }
    }
})

function detectServerConfig(host) {
    let keyPath = resolve(`/Applications/MAMP/Library/OpenSSL/certs/${host}.key`)
    let certificatePath = resolve(`/Applications/MAMP/Library/OpenSSL/certs/${host}.crt`)
    if (!fs.existsSync(keyPath)) {
        return {}
    }

    if (!fs.existsSync(certificatePath)) {
        return {}
    }

    return {
        hmr: {host},
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    }
}
