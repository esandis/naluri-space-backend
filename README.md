# Naluri Space - Backend
To do REST API call, simply access https://naluri-space-backend.herokuapp.com/api/pi

This app will count the pi values with increasing digits as scheduled by the scheduler (every hour). And then it will save the latest iteration to the DB.

# Tech Stack
- This app is built using [Symfony]. 
- This app is deployed using [Heroku].

# Current Limitations and Future Improvements
- PHP is not the best way to do this kind of complex algorithm computation. A Python based app should be considered for future development.
- The app is currently limited to count up to 1000 precision digits. This limit is needed because the current Heroku account only supports limited DB records.

   [Naluri Space]: <https://naluri-space-backend.herokuapp.com/>
   [Symfony]: <https://symfony.com/>
   [Heroku]: <https://www.heroku.com/>
