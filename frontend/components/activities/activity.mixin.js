export default {
  props: {
    color: String
  },
  computed: {
    editRoute: function() {
      return {
        name: 'activities-edit-id',
        params: {
          id: this.activity.id
        }
      }
    },
    typeStyle: function() {
      return {
        backgroundColor: this.color
      }
    }
  }
}
