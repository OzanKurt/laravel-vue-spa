import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {faUser} from '@fortawesome/free-solid-svg-icons/faUser'
import {faLock} from '@fortawesome/free-solid-svg-icons/faLock'
import {faSignOutAlt} from '@fortawesome/free-solid-svg-icons/faSignOutAlt'
import {faCog} from '@fortawesome/free-solid-svg-icons/faCog'
import {faCogs} from '@fortawesome/free-solid-svg-icons/faCogs'
import {faCaretUp} from '@fortawesome/free-solid-svg-icons/faCaretUp'
import {faCaretDown} from '@fortawesome/free-solid-svg-icons/faCaretDown'
import {faUserCog} from '@fortawesome/free-solid-svg-icons/faUserCog'

library.add(faUser, faLock, faSignOutAlt, faCog, faCogs, faCaretUp, faCaretDown, faUserCog)

import {faGithub} from '@fortawesome/free-brands-svg-icons/faGithub'
import {faFacebook} from '@fortawesome/free-brands-svg-icons/faFacebook'
import {faInstagram} from '@fortawesome/free-brands-svg-icons/faInstagram'
import {faTwitter} from '@fortawesome/free-brands-svg-icons/faTwitter'
import {faLinkedin} from '@fortawesome/free-brands-svg-icons/faLinkedin'
import {faGoogle} from '@fortawesome/free-brands-svg-icons/faGoogle'

library.add(faGithub, faFacebook, faInstagram, faTwitter, faLinkedin, faGoogle)

Vue.component('fa', FontAwesomeIcon)
