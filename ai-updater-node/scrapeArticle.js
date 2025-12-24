const axios = require("axios");
const cheerio = require("cheerio");
const https = require("https");

module.exports = async function scrapeArticle(url) {
  const { data } = await axios.get(url, {
    httpsAgent: new https.Agent({
      rejectUnauthorized: false,
    }),
  });

  const $ = cheerio.load(data);

  let content = "";

  $("article, main, .content, .post-content").each((_, el) => {
    content += $(el).text();
  });

  return content.replace(/\s+/g, " ").trim().slice(0, 8000);
};
