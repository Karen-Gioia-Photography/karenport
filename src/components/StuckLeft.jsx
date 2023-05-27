import { useState } from "preact/hooks";
import { Link } from "preact-router/match";
import PortfolioMenu from "./PortfolioMenu";

const StuckLeft = () => {
  const [portfolioExpanded, setPortfolioExpanded] = useState(false);

  return (
    <div class="stuckleft">
      <div id="logo">
        <Link href="/">
          <img src="/assets/canvas-deep.png" />
        </Link>
      </div>

      <div id="menu">
        <div id="home_item" class="menuItem">
          <Link href="/" activeClassName="active">
            Home
          </Link>
        </div>

        <div id="portflio_item" class="menuItem">
          <a onClick={() => setPortfolioExpanded(!portfolioExpanded)}>
            Portfolio
          </a>
          <div
            id="portfolio"
            style={{ display: portfolioExpanded ? "block" : "none" }}
          >
            <PortfolioMenu />
          </div>
        </div>

        <div id="about_item" class="menuItem">
          <Link href="/about" activeClassName="active">
            About Me
          </Link>
        </div>

        <div id="contact_item" class="menuItem">
          <Link href="/contact" activeClassName="active">
            Contact
          </Link>
        </div>
      </div>

      <div id="copyrights" class="">
        © {new Date().getFullYear()} Karen Gioia Photography
      </div>
    </div>
  );
};

export default StuckLeft;
