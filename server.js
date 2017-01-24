var app = require('express')();
var http = require('http').Server(app);
var io = require ('socket.io')(http);


app.get('/', function(req, res){
    res.sendFile(__dirname + '/Chat');
    // res.send('<h1>Hello world</h1>');
});


io.on('connection', function(socket){
    
    // connect
    console.log('A user connected.');
    
    // disconnect
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
    
    // message
    socket.on('chat message', function(msg){
        console.log('message: ' + msg);
        io.emit('chat message', msg);
    });
    
    // send a message to everyone except for certain socket
    socket.broadcast.emit('hi');
    
});


http.listen(3000, function(){
  console.log('listening on *:3000');
});