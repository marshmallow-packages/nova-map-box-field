import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-map-box', IndexField)
  app.component('detail-map-box', DetailField)
  app.component('form-map-box', FormField)
})
