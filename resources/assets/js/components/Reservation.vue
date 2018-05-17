<template>
    <div class="panel panel-default">
        <div class="panel-heading">Eventos</div>
        <div class="panel-body">
            <div v-for="(pt,kpt) in premiereTimes" v-show="premiereTimes.length" class="col-md-4 col-lg-4 col-xs-12">
                <div class="thumbnail" v-show="!pt.chairVisible">
                  <img src="https://cdn2.iconfinder.com/data/icons/cinema-and-television/500/Clapper_entertainment_film_movie_play_theate_cinematography_video_filming_camera-128.png" alt="Desde iconfinder">
                  <div class="caption">
                    <h3> {{ pt.premiere.name }} </h3>
                    <p> {{ pt.premiere.detail }} </p>
                    <button href="#" 
                            class="btn btn-primary" type="button" 
                            @click="premiereTimes[kpt]['chairVisible']=true"> 
                        Seleccionar butacos  
                    </button>
                  </div>
                </div>
                <div class="thumbnail" v-show="pt.chairVisible">
                    <div class="chairs">
                        <div v-for="rk in pt.chair.rows" class="rows-chair">
                            <div v-for="ck in pt.chair.columns" class="columns-chair">
                                <button v-if="reservations(kpt,rk-1,ck-1)" type="button" 
                                        :class="{'btn btn-xs':true,'btn-default':!pt.chairs[rk-1][ck-1],'btn-info':pt.chairs[rk-1][ck-1]}" 
                                        @click="selected(kpt,rk-1,ck-1)">
                                    <div class="point">{{ rk-1 }} - {{ ck-1 }}</div>
                                    <img src="https://cdn1.iconfinder.com/data/icons/unigrid-mechanics/60/025_chair_seat_car-24.png" alt="Desde iconfinder"> 
                                </button>

                                <button v-else type="button" 
                                        class="btn btn-xs btn-danger">
                                    <div class="point">{{ rk-1 }} - {{ ck-1 }}</div>
                                    <img src="https://cdn1.iconfinder.com/data/icons/unigrid-mechanics/60/025_chair_seat_car-24.png" alt="Desde iconfinder"> 
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="action" style="text-align:center">
                        <button class="btn btn-warning"  type="button" 
                                @click="reservation(kpt, pt.id, pt.ticket_price)"> 
                            Reservar 
                        </button>
                        <button class="btn btn-warning"  type="button" 
                                @click="premiereTimes[kpt]['chairVisible']=false"> 
                            Atras 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name:'Reservation',
        data:()=>{
            return {
                premiereTimes:[]
            }
        },
        props:{
            user:''
        },
        created(){
            this.loadingPremieres()
        },
        methods:{
            loadingPremieres(){
                axios.get(baseURL+'/reservation/premiereTimeAll').then( (res)=>{
                    if(res.data.submit){
                        this.premiereTimes = res.data.rows
                    }else{
                        this.$toasterE.warning(res.msn, {mark:1,timeout:1800})
                    }
                }).catch( (err)=> {
                    this.$toasterE.warning(err, {mark:1,timeout:1800})
                })
            },
            reservation(kpt, premiere_time_id, ticket_price){
                axios.post(baseURL+'/reservation/toAssing',{ premiere_time_id, chairs: this.premiereTimes[kpt]['chairs'], ticket_price }).then( (res)=>{
                    if(res.data.submit){
                       this.$toasterE.success("Reservacion procesada correctamente, te esperamos.", {mark:1,timeout:5800})
                       this.loadingPremieres();
                    }else{
                       this.$toasterE.warning(res.data.msn, {mark:1})
                    }
                }).catch( (err)=> {
                    this.$toasterE.warning(err, {mark:1})
                })
            },
            reservations(kpt, rk, ck){
                if( this.premiereTimes[kpt]['reservations'] ){
                    let reservations = this.premiereTimes[kpt]['reservations'];
                    for (var i = reservations.length - 1; i >= 0; i--) {
                        let  details = reservations[i]['details'] 
                        for (var k = details.length - 1; k >= 0; k--) {
                            if( parseInt(details[k]['row']) === rk && parseInt(details[k]['column']) === ck ){
                                return false
                            }  
                        }
                    }
                    return  true
                }
            },
            selected(kpt, rk, ck){
                this.$set(this.premiereTimes[kpt]['chairs'][rk], ck, ( (this.premiereTimes[kpt]['chairs'][rk][ck])?0:1 ) )
            }
        }
    }
</script>

<style lang="css">
.chairs{
    padding:3px;
    display: inline-flex;
}
.chairs .rows-chair{
    width: 100%;
}
.chairs .columns-chair{
    width: 34px;
    height: 50px;
    display: inline-block;
}
.chairs .columns-chair button .point{
    display: block;
    font-weight: bold;
}
</style>