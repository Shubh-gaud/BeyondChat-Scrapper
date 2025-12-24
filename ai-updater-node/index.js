require("dotenv").config();
const axios = require("axios");

const googleSearch = require("./googleSearch");
const scrapeArticle = require("./scrapeArticle");
const rewriteArticle = require("./llm");

async function run() {
  console.log("Fetching latest article from Laravel...");

  const { data } = await axios.get(process.env.LARAVEL_API);

  const original = data.find(a => a.type === "original");

  if (!original) {
    console.log("No original article found");
    return;
  }

  console.log("Searching Google...");
  const links = await googleSearch(original.title);

 if (links.length === 0) {
  console.log("No reference articles found. Proceeding with original content only.");
}


  console.log("Scraping reference articles...");
  const referenceContents = [];

  for (const link of links) {
    referenceContents.push(await scrapeArticle(link.link));
  }

  console.log("Calling Gemini to rewrite article...");
  const updatedContent = await rewriteArticle(original, referenceContents);

  console.log("Publishing updated article...");
  await axios.post(process.env.LARAVEL_API, {
    title: original.title,
    content: updatedContent,
    source_url: original.source_url,
    type: "updated",
    references: links.map(l => l.link)
  });

  console.log("Updated article published successfully!");
}

run().catch(err => {
  console.error("Error:", err.message);
});
