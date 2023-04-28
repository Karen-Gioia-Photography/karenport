const path = require("path");

module.exports = {
  mode: process.env["NODE_ENV"] || "development",

  entry: path.join(path.resolve(__dirname, "src"), "index.js"),
  output: {
    filename: "index.js",
    path: path.resolve(__dirname, "assets"),
  },

  target: "web",

  module: {
    rules: [
      {
        test: /\.(?:js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: [["@babel/preset-env", { targets: "defaults" }]],
            plugins: [
              [
                "@babel/plugin-transform-react-jsx",
                {
                  runtime: "automatic",
                  importSource: "preact",
                },
              ],
            ],
          },
        },
      },
    ],
  },

  resolveLoader: {
    modules: [path.join(__dirname, "node_modules")],
  },
  resolve: {
    extensions: [".js", ".jsx"],
    modules: [path.join(__dirname, "node_modules")],
    alias: {
      react: "preact/compat",
      "react-dom": "preact/compat", // Must be below test-utils
      "react/jsx-runtime": "preact/jsx-runtime",
    },
  },
};
