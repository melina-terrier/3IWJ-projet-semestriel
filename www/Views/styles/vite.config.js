import { defineConfig } from "vite";
import path from "path";



export default defineConfig({
	build: {
		lib: {
			entry: [path.resolve(__dirname, "./src/js/main.js"), path.resolve(__dirname, "./src/js/mainFront.js")],
			//entry: [path.resolve(__dirname, "./src/js/mainFront.js")],
			name: "gfm-project",
			formats: ["es"],
		},
		cssCodeSplit: true,

		rollupOptions: {
			output: {
				entryFileNames: "js/[name].js",
				assetFileNames: ({ name }) => {
					// Ne sera pas utilisé dans le cadre d'une génération de library...
					if (/\.(gif|jpe?g|png|svg)$/.test(name ?? "")) { // si le nom de fichier se termine par .gif, .jpeg, .jpg, .png ou .svg
						return "images/[name][extname]";
					}
					if (/\.css$/.test(name ?? "")) {
						// return "assets/css/[name]-[hash][extname]";
						return "css/[name][extname]";
					}
					// default value
					// ref: https://rollupjs.org/guide/en/#outputassetfilenames
					return "assets/[name]-[hash][extname]";
				},
			},
		},
	}, // ...
});
