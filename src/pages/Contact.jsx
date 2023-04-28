import { Fragment } from "preact";

const Contact = () => {
  return (
    <Fragment>
      <h1>Contact</h1>
      <p>
        {/* 142 Cresthill Avenue */}
        <br />
        Tonawanda, NY 14150
      </p>

      <p>
        Home: (716) 834-4438
        <br />
        Cell: (716) 435-4664
      </p>
      <p>Email: karen@karengioia.com</p>

      <br />
      <br />

      <p style="font-size: 0.9rem;">
        All images are the property of Karen Gioia and protected under US and
        International copyright laws. Copying, duplicating, saving as a digital
        file, printing, publishing in form of media including web, manipulating,
        transmitting or reproducing without the prior written permission of
        Karen Gioia is strictly forbidden and would constitute a breach of
        copyright.
      </p>
    </Fragment>
  );
};

export default Contact;
