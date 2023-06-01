import { useState } from "preact/hooks";
import { Router } from "preact-router";
import StuckLeft from "./components/StuckLeft";
import About from "./pages/About";
import Home from "./pages/Home";
import Contact from "./pages/Contact";
import Gallery from "./pages/Gallery";

const GALLERY_PATH_TOKEN = "/gallery/";

const App = () => {
  const [initialPortfolioOpen, setinitialPortfolioOpen] = useState(
    window.location.pathname.includes(GALLERY_PATH_TOKEN)
  );

  const handleRoute = (ev) => {
    if (ev.url.includes(GALLERY_PATH_TOKEN)) {
      setinitialPortfolioOpen(true);
    }
  };

  return (
    <div>
      <StuckLeft initialPortfolioOpen={initialPortfolioOpen} />
      <div class="content">
        <Router onChange={handleRoute}>
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
