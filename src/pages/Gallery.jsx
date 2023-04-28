import { useContentful } from "../useContentful";
import CarouselGallery from "../components/CarouselGallery";
import ListGallery from "../components/ListGallery";

const HOME_ENTRY_ID = "51z9h0rSyYmliq9YpY01nF";

const getQuery = (imageSetTag) => {
  return `
  {
    imageSetCollection(where: {
      contentfulMetadata: {
        tags: {
          id_contains_all: ["${imageSetTag}"]
        }
      }
    }) {
      items {
        name
        isList
        imagesCollection {
          items{
            url
            title
            description
          }
        }
      }
    }
  }`;
};

const Gallery = ({ galleryId }) => {
  const [isLoading, response, errors] = useContentful(getQuery(galleryId));

  if (isLoading) {
    return null;
  }

  if (errors) {
    console.error(errors);
    return null;
  }

  const items = response.imageSetCollection.items;
  if (items.length === 0) {
    return null;
  }
  const imageSet = items[0];

  if (imageSet.isList) {
    return <ListGallery imageSet={imageSet} />;
  } else {
    const images = imageSet.imagesCollection.items;
    return <CarouselGallery images={images} withThumbs />;
  }
};

export default Gallery;
