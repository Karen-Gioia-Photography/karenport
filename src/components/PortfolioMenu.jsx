import { Fragment } from "preact";
import { Link } from "preact-router/match";
import { useContentful } from "../useContentful";

const query = `
{
  imageSetCollection {
    items {
      name
      contentfulMetadata{
        tags{
          id
        }
      }
    }
  }
}
`;

const PortfolioItem = ({ imageSet }) => {
  const tags = imageSet.contentfulMetadata.tags;
  if (tags.length === 0) {
    return null;
  }

  return (
    <div class="gallery">
      <Link href={`/gallery/${tags[0].id}`} activeClassName="active">
        {imageSet.name}
      </Link>
    </div>
  );
};

const PortfolioMenu = () => {
  const [isLoading, response, errors] = useContentful(query);

  if (isLoading) {
    return null;
  }

  if (errors) {
    console.error(errors);
    return null;
  }

  const imageSetItems = response.imageSetCollection.items.filter(
    (item) => item.label !== "home"
  );

  return (
    <Fragment>
      {imageSetItems.map((item) => (
        <PortfolioItem imageSet={item} />
      ))}
    </Fragment>
  );
};

export default PortfolioMenu;
