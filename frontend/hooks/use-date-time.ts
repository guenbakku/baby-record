import moment from 'moment-timezone'

type Moment = typeof moment

const useDateTime = (moment: Moment) => {
  /**
   * Calculate age
   *
   * @param birthday - birthday string
   * @param reference - reference day string
   * @returns number array contains year, month, day
   */
  const calcAge = (birthday: string, reference?: string) => {
    if (reference === undefined) {
      reference = moment().toJSON()
    }

    const diffTime = moment(reference).diff(birthday)
    if (diffTime < 0) {
      throw new Error('reference day can no be less than birthday')
    }

    const duration = moment.duration(diffTime)
    const age = [duration.years(), duration.months(), duration.days()]

    return age
  }

  return {
    calcAge
  }
}

export default useDateTime
