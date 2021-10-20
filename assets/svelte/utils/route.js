const routes = require('./routes.json')
import Routing from '../../../public/bundles/fosjsrouting/js/router.min.js'

Routing.setRoutingData(routes)

const route = (name, params, absolute = false) => Routing.generate(name, params, absolute)

export {
    route
}