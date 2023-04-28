const About = () => {
  return (
    <div id="about">
      <h1>About Me</h1>

      <div class="about_flex">
        <div class="about_image">
          <img src="/assets/mephoto300.jpg" />
        </div>
        <div class="about_text">
          <p>
            I graduated from Columbia College Chicago in May 2012 with a BFA in
            photography and a minor in web development. Before moving to
            Chicago, I spent three years at Case Western Reserve University and
            had majored in Computational Biology with a minor in photography.
          </p>
          {/* <p>
            I have always enjoyed taking pictures, but it was not until 2009 when I started
            thinking of photography as a career.
        </p> */}
          <p>
            I have very diverse interests, but my main interests are in action
            sports photography and photojournalism.
          </p>
          <p>
            I also photograph real estate for local realtors' online listings.
          </p>
          <p>
            I attended the 2012 Sports Shooter Academy IX Workshop and the 2017
            NPPA Multimedia Immersion Workshop.
          </p>
          <p>
            I was born in Buffalo, NY and grew up in the western New York area
            near Niagara Falls. I moved to Cleveland, OH in 2006 and lived there
            for three years while I attended Case Western Reserve University. I
            moved to Chicago, IL in 2009 to pursue my degree in photography and
            lived in the city for five years. In 2014, I returned to western New
            York to continue to grow my photography business.
          </p>
          <br />
          <p>
            <a href="assets/resume.pdf">-- My Resume --</a>
          </p>
        </div>
      </div>
    </div>
  );
};

export default About;
