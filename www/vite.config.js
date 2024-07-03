import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
    build: {
        outDir: 'Public/Style/dist',
        emptyOutDir: true,  // Ajoutez cette ligne pour vider le répertoire de sortie avant de construire
        rollupOptions: {
            input: path.resolve(__dirname, "./Public/Assets/Style/src/js/main.js"),
            output: {
                entryFileNames: "js/[name].js",
                assetFileNames: ({ name }) => {
                    if (/\.(gif|jpe?g|png|svg)$/.test(name ?? "")) {
                        return "images/[name][extname]";
                    }
                    if (/\.css$/.test(name ?? "")) {
                        return "css/[name][extname]";
                    }
                    return "assets/[name]-[hash][extname]";
                },
            },
        },
    },
    server: {
        watch: {
            ignored: ['**/Public/Style/dist/**'],  // Ignorer le répertoire de sortie
        },
    },
});
