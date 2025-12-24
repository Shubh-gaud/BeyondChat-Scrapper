// function App() {
//   return (
//     <div className="min-h-screen bg-gray-100 flex items-center justify-center">
//       <h1 className="text-3xl font-bold text-blue-600">
//         Tailwind is working 🚀
//       </h1>
//     </div>
//   );
// }

// export default App;
import Navbar from './components/Navbar';
import Home from './pages/Home';

function App() {
  return (
    <>
      <Navbar />
      <Home />
    </>
  );
}

export default App;

