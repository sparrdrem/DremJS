/*
    Application File 
    Author  : Shane Doyle
    Date    : 31/10/2012
    This file is used to run the application.
*/
var express = require("express");
var app = module.exports = express();

var config = require("./config.js")(app, express);

require("./routes/routes")(app);

app.listen(3000);
