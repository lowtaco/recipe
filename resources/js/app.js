require('./bootstrap');

import { createApp, reactive } from 'vue';
import router from './router';

import MainScreen from './components/MainScreen';

import SplashScreen from './components/splash_screen/splash_screen';

import Icon from './components/core/icon_pack';

import PhotoUploader from './components/core/elements/photo_uploader';

import Toast from './components/core/elements/toast'

import Checkbox from './components/core/elements/checkbox';
import Switch from './components/core/elements/switch';
import Select from './components/core/elements/select';
import Draggable from './components/core/elements/draggable_list';
import SearchBar from './components/core/elements/search_bar';
import MPCategories from './components/core/elements/mp_categories';
import MPCategoriesSlider from './components/core/elements/mp_category_slider';
import SearchTags from './components/core/elements/search_tags';
import PopupMenu from './components/core/elements/popup_menu';
import Confirm from './components/core/elements/confirm';
import Loader from './components/core/elements/loader';
import FormTitle from './components/core/elements/form_title';
import TimeInput from './components/core/elements/time_input';
import DifficultySpicinessEditor from './components/core/elements/difficulty-spiciness-editor';
import DifficultySpicinessViewer from './components/core/elements/difficulty-spiciness-viewer';
import AutoTextarea from './components/core/elements/auto_textarea';
import NumEditor from './components/core/elements/num_editor';
import Verified from './components/core/elements/verified';

import { утилиты } from '@/core/утилиты';
window.утилиты = утилиты;

import GoogleIdentity from 'vue-google-identity'
import Vue3TouchEvents from "vue3-touch-events";

const app = createApp({});

app.use(GoogleIdentity, {
  clientId: "762182711837-3i1gve5ivqa9d5q6j8kduk190u602p9s.apps.googleusercontent.com",
});

app.use(Vue3TouchEvents);

import mobile_menu from '../mobile_menu.json';
app.config.globalProperties.$mobile_menu = reactive(mobile_menu);

import strings from '../strings.json';
app.config.globalProperties.$strings = reactive(strings);

import shopping_lists from '../shopping_lists.json';
app.config.globalProperties.$shopping_lists = reactive(shopping_lists);

import addListVariables from '../addListVariables.json';
app.config.globalProperties.$addListVariables = reactive(addListVariables);

app.component('main-component', MainScreen)
app.component('splash-screen', SplashScreen)
app.component('icon', Icon)
app.component('checkbox', Checkbox)
app.component('switch-input', Switch)
app.component('search-bar', SearchBar)
app.component('mp-categories', MPCategories)
app.component('mp-slider', MPCategoriesSlider)
app.component('search-tags', SearchTags)
app.component('popup-menu', PopupMenu)
app.component('confirm', Confirm)
app.component('loader', Loader)
app.component('form-title', FormTitle)
app.component('time-input', TimeInput)
app.component('difficulty-spiciness-editor', DifficultySpicinessEditor)
app.component('difficulty-spiciness-viewer', DifficultySpicinessViewer)
app.component('r-select', Select)
app.component('draggable-list', Draggable)
app.component('photo-uploader', PhotoUploader)
app.component('auto-textarea', AutoTextarea)
app.component('num-editor', NumEditor)
app.component('toast', Toast)
app.component('verified', Verified)

app.use(router)
app.mount('#app')
