import { useEffect, useState } from "preact/hooks";

const CONTENTFUL_SPACE_ID = "wae9rq1y8oon";

const CONTENTFUL_PUBLISHED_TOKEN =
  "BU0EAgTuPkKWRJFN3gjkonCTayEZW1V4J6_GEcsUpoE";
const CONTENTFUL_PREVIEW_TOKEN = "piG1q7uCmQEVGxCif32IHSwIPnrxE7LUazkE1-Kcx7c";

export const useContentful = (query) => {
  const [isLoading, setIsLoading] = useState(true);
  const [response, setResponse] = useState(null);
  const [errors, setErrors] = useState(null);

  useEffect(() => {
    setIsLoading(true);
    window
      .fetch(
        `https://graphql.contentful.com/content/v1/spaces/${CONTENTFUL_SPACE_ID}/`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            // Authenticate the request
            Authorization: `Bearer ${CONTENTFUL_PUBLISHED_TOKEN}`,
          },
          // send the GraphQL query
          body: JSON.stringify({ query }),
        }
      )
      .then((resp) => resp.json())
      .then(({ data, errors }) => {
        setIsLoading(false);
        if (errors) {
          setErrors(errors);
        } else {
          // rerender the entire component with new data
          setResponse(data);
        }
      })
      .catch((err) => {
        setIsLoading(false);
        if (err) {
          setErrors(err);
        } else {
          setErrors(new Error("Error occured while fetching content"));
        }
      });
  }, [query]);

  return [isLoading, response, errors];
};
