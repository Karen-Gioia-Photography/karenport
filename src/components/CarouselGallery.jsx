import { Link } from "preact-router";
import { useState, useCallback, useEffect, useRef } from "preact/hooks";

const SLIDE_WIDTH = 800;
const NAV_WIDTH = 40;
const SLIDE_TIMER_DURATION = 5000; //ms

const CarouselGallery = ({ images, withThumbs, withTimer }) => {
  const [slide, setSlide] = useState(0);
  const [navIdx, setNavIdx] = useState(0);

  const crementSlide = useCallback(
    (idxCrement, callback = undefined) => {
      let newIdx = slide + idxCrement;
      if (newIdx >= images.length) {
        newIdx = 0;
      } else if (newIdx < 0) {
        newIdx = images.length - 1;
      }
      setSlide(newIdx, callback);
    },
    [slide, images]
  );

  const crementNav = useCallback(
    (idxCrement, callback = undefined) => {
      let newIdx = navIdx + idxCrement;
      if (newIdx >= images.length) {
        newIdx = 0;
      } else if (newIdx < 0) {
        newIdx = images.length - 1;
      }
      setNavIdx(newIdx, callback);
    },
    [navIdx, images]
  );

  const crementSlideRef = useRef(crementSlide);

  useEffect(() => {
    crementSlideRef.current = crementSlide;
  }, [crementSlide]);

  useEffect(() => {
    if (withTimer) {
      const timer = setInterval(() => {
        crementSlideRef.current(1);
      }, SLIDE_TIMER_DURATION);
      return () => {
        clearInterval(timer);
      };
    }
  }, []);

  return (
    <div id="gallery_container">
      <div id="unit">
        <div className="arrowbox left">
          <div className="photoArrow left" onClick={() => crementSlide(-1)} />
          <div className="navArrow left" onClick={() => crementNav(-3)}>
            ◀
          </div>
        </div>
        <div className="window">
          <div className="navbar" style={{ left: -navIdx * NAV_WIDTH }}>
            <div className={`nav ${withThumbs ? "thumb" : "node"}`}>
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
                  <Link href={`/gallery/${tags[0].id}`} className="slide">
                    <img src={image.url} />
                  </Link>
                );
              }
            })}
          </div>
        </div>
        <div className="arrowbox right">
          <div className="photoArrow right" onClick={() => crementSlide(1)} />
          <div className="navArrow right" onClick={() => crementNav(3)}>
            ▶
          </div>
        </div>
      </div>
    </div>
  );
};

export default CarouselGallery;
