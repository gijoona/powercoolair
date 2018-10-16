const express = require('express');
var app = express();

app.get('/', (req, res) => {
  res.send('success');
});

app.listen(8088, () => {
  console.log('Powercoolair node server listen port 8088');
});
