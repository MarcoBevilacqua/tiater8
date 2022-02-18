const path = require("path");

module.exports = {
    resolve: {
        extensions: [".js", ".ts", ".tsx", ".vue"],
        alias: {
            "@": path.resolve("resources/js"),
        },
    },
};
