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
        
        // TODO: remove testing line
        var message = 'Lets welcome a new buddy to ' + room;
        io.sockets.in(room).emit('chat message', message);
        console.log("emited message: " + message);
    });
    
    // message
    socket.on('system broadcasting', function(msg){
        io.emit('chat message', msg);
    });
    
    // vote
    socket.on('vote', function(data){
        io.emit('vote', data);
    });
    
    // message
    socket.on('thread', function(data){
        console.log(data);
        var r = data['room'];
        var d = data['html'];
        
        io.sockets.in(r).emit('thread', d);
    });
    
    /*
    // send a message to everyone except for certain socket
    socket.broadcast.emit('hi');
    */
    
});