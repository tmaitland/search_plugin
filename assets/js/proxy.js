function proxy() {
    const express = require('express');
    const request = require('request');

    const app = express();

    app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    next();
    });

    app.get('&amp;output=rss', (req, res) => {
    request(
        { url: 'http://news.google.com/news?q=*&amp;output=rss' },
        (error, response, body) => {
        if (error || response.statusCode !== 200) {
            return res.status(500).json({ type: 'error', message: err.message });
        }

        res.json(JSON.parse(body));
        }
    )
    });

    const PORT = process.env.PORT || 3000;
    app.listen(PORT, () => console.log(`listening on ${PORT}`));
}