const search = require("google-it");

module.exports = async function googleSearch(query) {
  const results = await search({ query });

  return results
    .filter(r =>
      r.link &&
      (r.link.includes("blog") || r.link.includes("article"))
    )
    .slice(0, 2)
    .map(r => ({
      title: r.title,
      link: r.link
    }));
};
