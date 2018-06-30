/*
    Application Routes
    Author  : Shane Doyle
    Date    : 31/10/2012
    This file is used to store the routes
    for the application.
*/
module.exports = function(app) {
	var title = "Simple Paint App";
	
	// Default Route
	app.get("/", function(req, res) {
		res.render("index.jade", {
			title: title
		});
	});
};
