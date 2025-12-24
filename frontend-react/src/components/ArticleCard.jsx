export default function ArticleCard({ article }) {
  return (
    <div className="bg-white rounded shadow p-5 mb-6">
      <h2 className="text-xl font-semibold mb-1">{article.title}</h2>

      <span className={`text-sm px-2 py-1 rounded 
        ${article.type === 'original' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700'}`}>
        {article.type.toUpperCase()}
      </span>

      <p className="mt-3 text-gray-700">
        {article.content.slice(0, 300)}...
      </p>

      {article.references && (
        <div className="mt-3">
          <h4 className="font-semibold">References:</h4>
          <ul className="list-disc ml-5 text-blue-600 text-sm">
            {article.references.map((ref, i) => (
              <li key={i}>
                <a href={ref} target="_blank" rel="noreferrer">{ref}</a>
              </li>
            ))}
          </ul>
        </div>
      )}
    </div>
  );
}
