import { Link } from "preact-router";
import { useState, useCallback } from "preact/hooks";

const SLIDE_WIDTH = 800;

const CarouselGallery = ({ images, withThumbs }) => {
  const [slide, setSlide] = useState(0);

  const crement = useCallback(
    (idxCrement) => {
      const newIdx = slide + idxCrement;
      if (newIdx >= images.length) {
        setSlide(0);
      } else if (newIdx < 0) {
        setSlide(images.length - 1);
      } else {
        setSlide(newIdx);
      }
    },
    [slide, images]
  );

  return (
    <div id="gallery_container">
      <div id="unit">
        <div className="arrowbox left">
          <div className="photoArrow left" onClick={() => crement(-1)} />
          <div className="navArrow left">◀</div>
        </div>
        <div className="window">
          <div className="navbar">
            <div className="nav">
              {images.map((image, ix) => {
                if (withThumbs) {
                  return (
                    <div
                      className={`navThumb ${ix === slide ? "active" : ""}`}
                      onClick={() => {
                        setSlide(ix);
                      }}
                    >
                      <img src={image.url} />
                    </div>
                  );
                } else {
                  return (
                    <div
                      className={`navNode ${ix === slide ? "active" : ""}`}
                      onClick={() => {
                        setSlide(ix);
                      }}
                    >
                      ●
                    </div>
                  );
                }
              })}
            </div>
          </div>
          <div className="images" style={{ left: -slide * SLIDE_WIDTH }}>
            {images.map((image) => {
              const tags = image.contentfulMetadata?.tags;
              if (!tags || tags.length === 0) {
                return (
                  <span className="slide">
                    <img src={image.url} />
                  </span>
                );
              } else {
                return (
                  <Link href={`/portfolio/${tags[0].id}`} className="slide">
                    <img src={image.url} />
                  </Link>
                );
              }
            })}
          </div>
        </div>
        <div className="arrowbox right">
          <div className="photoArrow right" onClick={() => crement(1)} />
          <div className="navArrow right">▶</div>
        </div>
      </div>
    </div>
  );
};

export default CarouselGallery;
