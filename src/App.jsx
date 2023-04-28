import { Router } from "preact-router";
import StuckLeft from "./components/StuckLeft";
import About from "./pages/About";
import Home from "./pages/Home";
import Contact from "./pages/Contact";
import Gallery from "./pages/Gallery";

const App = () => {
  return (
    <div>
      <StuckLeft />
      <div class="content">
        <Router>
          <Home path="/" />
          <About path="/about" />
          <Contact path="/contact" />
          <Gallery path="/gallery/:galleryId" />
          <Home default />
        </Router>
      </div>
    </div>
  );
};

export default App;
