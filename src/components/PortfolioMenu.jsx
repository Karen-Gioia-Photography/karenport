import { Fragment } from "preact";
import { Link } from "preact-router/match";
import { useContentful } from "../useContentful";

const LISTING_ENTRY_ID = "2sHHTRhUx9Zxqo89WEJF38";

const query = `
{
  portfolioListing(id:"${LISTING_ENTRY_ID}") {
    imageSetsCollection {
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
}
`;

const PortfolioItem = ({ imageSet }) => {
  const tags = imageSet.contentfulMetadata.tags;
  if (tags.length === 0) {
    return null;
  }

  const tagId = tags[0].id;
  const pathname = window.location.pathname;

  return (
    <div class="gallery">
      <Link href={`/gallery/${tagId}`} activeClassName="active">
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

  const imageSetItems =
    response.portfolioListing.imageSetsCollection.items.filter(
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
