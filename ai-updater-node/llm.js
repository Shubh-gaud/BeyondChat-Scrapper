const { GoogleGenerativeAI } = require("@google/generative-ai");

const genAI = new GoogleGenerativeAI(process.env.GEMINI_API_KEY);

module.exports = async function rewriteArticle(original, references) {

  const model = genAI.getGenerativeModel({
    model: "text-bison-001",
  });

  const prompt = `
Rewrite the following article to improve SEO, clarity, and structure.

${references.length > 0
  ? "Use the reference articles only for tone and structure."
  : "Rewrite using general blog SEO best practices."}

Original Article:
${original.content}

${references.length > 0
  ? `Reference Articles:\n${references.join("\n\n")}`
  : ""}

At the end, add a section titled "References".
`;

  const result = await model.generateContent(prompt);

  return result.response.text();
};