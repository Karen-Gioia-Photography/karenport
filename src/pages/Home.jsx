import { useContentful } from "../useContentful";
import CarouselGallery from "../components/CarouselGallery";

const HOME_ENTRY_ID = "51z9h0rSyYmliq9YpY01nF";

const query = `
{
  imageSet(id:"${HOME_ENTRY_ID}") {
    name
    imagesCollection {
      items{
        url
        contentfulMetadata{
          tags{
            id
          }
        }
      }
    }
  }
}
`;

const Home = () => {
  const [isLoading, response, errors] = useContentful(query);

  if (isLoading) {
    return null;
  }

  if (errors) {
    console.error(errors);
    return null;
  }

  const { imagesCollection } = response.imageSet;

  return <CarouselGallery images={imagesCollection.items} withTimer />;
};

export default Home;
