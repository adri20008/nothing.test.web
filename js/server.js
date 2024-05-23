const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const cors = require('cors');

const app = express();

app.use(cors());
app.use(bodyParser.json());

// Create MySQL connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'webkeyman'
});

// Connect to MySQL
db.connect((err) => {
    if (err) {
        console.error('Error connecting to MySQL:', err);
        return;
    }
    console.log('Connected to MySQL');
});

// API endpoint for password verification
app.post('/verify-password', (req, res) => {
    const { password } = req.body;
    const query = 'SELECT * FROM passwords WHERE password = ?';
    db.query(query, [password], (err, results) => {
        if (err) {
            console.error('Error querying MySQL:', err);
            res.status(500).send('Internal Server Error');
            return;
        }
        if (results.length > 0) {
            res.status(200).send('Password is correct');
        } else {
            res.status(401).send('Incorrect password');
        }
    });
});

app.listen(3000, () => {
    console.log('Server running');
});
