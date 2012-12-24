
/**
 * Module dependencies.
 */

var express = require('express')
  , http = require('http')
  , path = require('path');

var app = express();

// mysql conection
var mysql = require('mysql');
console.log('Connecting to MySQL...');

app.configure(function(){
  app.set('port', process.env.PORT || 3000);
  app.set('views', __dirname + '/views');
  app.set('view engine', 'jade');
  app.use(express.favicon());
  app.use(express.logger('dev'));
  app.use(express.bodyParser());
  app.use(express.methodOverride());
  app.use(app.router);
  app.use(express.static(path.join(__dirname, 'app')));
});
app.configure('development', function(){
  app.use(express.errorHandler());
});

/*
app.get('/:name', function(req), res) {
  // get name.json.get file!
  res.send(name.json.get);
});

app.get('/:name/:id', function(req), res) {
  // get name.json.get file!
  res.send(name.json.get.id);
});

app.post('/:name', function(req), res) {
  // get name.json.get file!
  res.send(name.json.post);
});

app.put('/:name', function(req), res) {
  // get name.json.get file!
  res.send(name.json.put);
});

app.delete('/:name', function(req), res) {
  // get name.json.get file!
  res.send(name.json.delete);
});
*/

function connectionServer(){
  var client = mysql.createConnection({
    host : 'localhost',
    user : 'root',
    password : '',
    database : 'ppm',
  });
  client.connect();
  return client;
}

app.get('/products.json', function(req, res){
  var client = connectionServer();
  client.query('SELECT * from product', function selectCb(err, rows, fields){
    if (err) throw err;
    res.send(JSON.stringify(rows));
  });
  client.end();
});

app.post('/products.json', function(req, res){
  var data = {};
  data.title = req.body.name || 'hello world';
  data.time = req.body.time || new Date();
  data.price = req.body.price || 1;
  res.send(data);
});

app.get('/products.json/:id', function(req, res){
  var id = req.params.id;
  var client = connectionServer();
  client.query('SELECT * from product where id='+id, function selectCb(err, rows, fields){
    if (err) throw err;
    res.send(JSON.stringify(rows[0]));
  });
});


http.createServer(app).listen(app.get('port'), function(){
  console.log("Express server listening on port " + app.get('port'));
});
