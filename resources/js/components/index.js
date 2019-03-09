import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import SlideUpDown from 'vue-slide-up-down'
import { HasError, AlertError, AlertSuccess } from 'vform'

import FormGroup from './Form/FormGroup'

// Components that are registered globaly.
[
    FormGroup,
    Card,
    Child,
    Button,
    Checkbox,
    HasError,
    AlertError,
    SlideUpDown,
    AlertSuccess,
].forEach(Component => {
    Vue.component(Component.name, Component)
})

import SideBarCard from './SideBar/Card'
import SideBarListItem from './SideBar/ListItem'
[
    SideBarCard,
    SideBarListItem,
].forEach(Component => {
    Vue.component(Component.name, Component)
})
