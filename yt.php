<!DOCTYPE html>
<html>
<head>
  <title>YouTube Video Search</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      padding: 20px;
    }
    .btn-secondary {
    --bs-btn-color: #fff;
    --bs-btn-bg: #0c67ec;
    --bs-btn-border-color: #0c67ec;
    }
    .btn:hover {
    color: var(--bs-btn-hover-color);
    background-color: #ff0000;
    border-color: #ff0000;
}
    .search-container {
      max-width: 600px;
      margin: 0 auto;
    }
    .video-item{
        padding-bottom: 25px;
    }
    .video-container {
      margin-top: 20px;
    }
    .video-container h2 {
      font-size: 20px;
      margin-bottom: 10px;
    }
    .video-container iframe {
      width: 100%;
      height: 315px;
    }
    .pagination-buttons {
      text-align: center;
      margin-top: 20px;
    }
    .pagination-buttons button {
      margin: 5px;
    }

    /* Responsive CSS */
    @media (max-width: 767px) {
      .video-container iframe {
        height: 200px;
      }
      .video-container h2 {
      font-size: 13px;      
    }
    }
    .search-container {
      max-width: auto;
      margin: 0 auto;
      display: flex;
    }
    .form-control{
      border-top-right-radius: unset;
      border-bottom-right-radius: unset;
    }
    .btn-sec{
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        border-top-left-radius: unset;
        border-bottom-left-radius: unset;
    }

    @media (max-width: 576px) {
      .search-container {
        max-width: 100%;
      }
      .video-container iframe {
        height: 150px;
      }
    }
    .search-container {
      max-width: auto;
      margin: 0 auto;
      display: flex;
      border-top-right-radius: unset;
      border-bottom-right-radius: unset;
    }    
    .form-control{
      border-top-right-radius: unset;
      border-bottom-right-radius: unset;
    }    
  </style>
</head>
<body>
  <div id="root"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.development.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.development.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/3.0.0/fetch.min.js"></script>

  <script type="text/babel">
    const { useState, useEffect } = React;

    function App() {
      const [searchQuery, setSearchQuery] = useState('');
      const [videos, setVideos] = useState([]);
      const [nextPageToken, setNextPageToken] = useState('');
      const [prevPageToken, setPrevPageToken] = useState('');

      const apiKey = 'API-key'; // Replace with your YouTube API key

      const searchVideos = async (pageToken = '') => {
        try {
          const response = await fetch(
            `https://www.googleapis.com/youtube/v3/search?part=snippet&q=${encodeURIComponent(
              searchQuery
            )}&type=video&maxResults=5&key=${apiKey}&pageToken=${pageToken}`
          );
          const data = await response.json();
          setVideos(data.items);
          setNextPageToken(data.nextPageToken);
          setPrevPageToken(data.prevPageToken);
        } catch (error) {
          console.error('Error:', error);
          setVideos([]);
          setNextPageToken('');
          setPrevPageToken('');
        }
      };

      useEffect(() => {
        searchVideos();
      }, []);

      const handlePrevPage = () => {
        searchVideos(prevPageToken);
      };

      const handleNextPage = () => {
        searchVideos(nextPageToken);
      };

      return (
        <div className="container">
          <h1 className="text-center">YouTube Video Search</h1>
          <div className="search-container">
            <input
              type="text"
              className="form-control"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              placeholder="Enter your search video"
            />
            <button className="btn btn-primary btn-sec" onClick={() => searchVideos()}>
              Search
            </button>
          </div>
          {videos.length > 0 ? (
            <div className="video-container ">
              {videos.map((video) => (
                <div key={video.id.videoId} className="video-item">
                  <h2>{video.snippet.title}</h2>
                  <iframe
                    width="560"
                    height="315"
                    src={`https://www.youtube.com/embed/${video.id.videoId}`}
                    frameBorder="0"
                    allow="autoplay; encrypted-media"
                    allowFullScreen
                  ></iframe>
                  <div className="video-link">
                    <a
                      href={`https://www.youtube.com/watch?v=${video.id.videoId}`}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="btn btn-primary"
                    >
                      Watch on YouTube
                    </a>
                  </div>
                </div>
              ))}
              <div className="pagination-buttons">
                <button
                  className="btn btn-secondary"
                  onClick={handlePrevPage}
                  disabled={!prevPageToken}
                >
                  Previous
                </button>
                <button
                  className="btn btn-secondary"
                  onClick={handleNextPage}
                  disabled={!nextPageToken}
                >
                  Next
                </button>
              </div>
            </div>
          ) : (
            <div className="no-results">No videos found.</div>
          )}
        </div>
      );
    }

    ReactDOM.render(<App />, document.getElementById('root'));
  </script>
 <!-- Default Statcounter code for Sanjay Kumar Sharma
        https://sanjayksharma.in/ -->
        <script type="text/javascript">
        var sc_project=12852414; 
        var sc_invisible=0; 
        var sc_security="196bb9ee"; 
        var scJsHost = "https://";
        document.write("<sc"+"ript type='text/javascript' src='" +
        scJsHost+
        "statcounter.com/counter/counter.js'></"+"script>");
        </script>
        <noscript><div class="statcounter"><a title="Web Analytics"
        href="https://statcounter.com/" target="_blank"><img
        class="statcounter"
        src="https://c.statcounter.com/12852414/0/196bb9ee/0/"
        alt="Web Analytics"
        referrerPolicy="no-referrer-when-downgrade"></a></div></noscript>
        <!-- End of Statcounter Code -->
</body>
</html>
