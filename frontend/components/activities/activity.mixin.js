export default {
  props: {
    color: String
  },
  computed: {
    editRoute() {
      return {
        name: 'activities-edit-id',
        params: {
          id: this.activity.id
        }
      }
    },
    typeStyle() {
      return {
        backgroundColor: this.color
      }
    }
  }
}
