var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);


app.get('/', function(req, res){
    res.sendFile(__dirname + '/Chat');
    // res.send('<h1>Hello world</h1>');
});


// http.listen(3000, funcion(){
io.listen(3000, function(){
  console.log('listening on *:3000');
});


io.on('connection', function(socket){
    
    // connect
    console.log('A user connected.');
    
    // disconnect
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
    
    // once a client has connected, we expect to get a ping from them saying what room they want to join
    socket.on('room', function(room) {
        socket.join(room);
        console.log("someone joined " + room);
        
        var message = 'Lets welcome a new buddy to ' + room;
        io.sockets.in(room).emit('chat message', message);
        console.log("emited message: " + message);
    });
    
    // message
    socket.on('chat message', function(msg){
        console.log('message: ' + msg);
        io.emit('chat message', msg);
    });
    
    /*
    // send a message to everyone except for certain socket
    socket.broadcast.emit('hi');
    */
    
});