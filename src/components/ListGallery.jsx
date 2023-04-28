import { Link } from "preact-router";

const ListGallery = ({ imageSet }) => {
  const images = imageSet.imagesCollection.items;

  return (
    <div id="scrollist">
      <h1>{imageSet.name}</h1>
      {images.map((image) => (
        <div className="scrollistItem">
          <Link href={image.description} target="_blank">
            <span className="scrollistImage">
              <img src={image.url} />
            </span>
            <span className="scrollistDescription">{image.title}</span>
          </Link>
        </div>
      ))}
    </div>
  );
};

export default ListGallery;
