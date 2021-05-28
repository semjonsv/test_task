<template>
<div>
    <div class="container">
        <div v-for="division in divisions" :key="division.name">
            <h3 class="d-inline p-2">{{division.name}}</h3> 
            <form class="d-inline p-2" :action="'/generate/division-matches/' + division.id" method="POST">
                <input type="hidden" name="_token" v-bind:value="csrf">
                <input class="btn btn-primary" type="submit" :value="'Generate '+ division.name">
            </form>    
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Teams</th>
                    <th v-for="team in division.teams" :key="team.id">{{team.name}}</th>
                    <th>Score</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="team in division.teams" :key="team.id">
                    <td>{{team.name}}</td>
                    <td v-for="match in team.matches" :key="match.id">
                        <span v-if="match.matchable_id === match.oponent_id">*</span>
                        <span v-else-if="match.winner_id === null"></span>
                        <span v-else-if="match.winner_id === team.id"> 1:0</span>
                        <span v-else>0:1</span>
                    </td>
                    <td>{{team.score}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div>
            <h3 class="d-inline p-2">Playoffs</h3>
            <form class="d-inline p-2" action="/generate/playoff-matches" method="POST">
                <input type="hidden" name="_token" v-bind:value="csrf">
                <input class="btn btn-primary" type="submit" value="Generate Playoffs">
            </form>
            <table class="table table-bordered">
            <tr>
            <td>
                <table class="table">
                    <thead>
                        <tr>
                            <td>-</td>
                        </tr>
                    </thead>
                    <tbody v-for="playoff in playoffs" :key="playoff.id">
                        <tr class="table">
                            <td height="100">
                                {{playoff.team_name}} ({{playoff.division_name}}) 
                                <br>
                                {{playoff.oponent_name}} ({{playoff.op_division_name}})
                                <br>
                                {{playoff.winner_id ? (playoff.winner_id === playoff.team_id ? '1:0' : '0:1') : '-'}}
                            </td>
                        </tr>
                        <tr>
                            <td height="100"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Semi-final</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td height="100"></td></tr>
                        <tr>
                            <td height="100" v-if="semis.length > 0">
                                {{semis[0].team_name}} ({{semis[0].division_name}}) 
                                <br>
                                {{semis[0].oponent_name}} ({{semis[0].op_division_name}})
                                <br>
                                {{semis[0].winner_id ? (semis[0].winner_id === semis[0].team_id ? '1:0' : '0:1') : '-'}}
                            </td>
                            <td height="100" v-else></td>
                        </tr>
                        <tr><td height="100"></td></tr>
                        <tr><td height="100"></td></tr>
                        <tr><td height="100"></td></tr>
                        <tr>
                            <td height="100" v-if="semis.length === 2">
                                {{semis[1].team_name}} ({{semis[1].division_name}}) 
                                <br>
                                {{semis[1].oponent_name}} ({{semis[1].op_division_name}})
                                <br>
                                {{semis[1].winner_id ? (semis[1].winner_id === semis[1].team_id ? '1:0' : '0:1') : '-'}}
                            </td>
                            <td height="100" v-else></td>
                        </tr>
                        <tr><td height="100"></td></tr>
                        <tr><td height="100"></td></tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Final</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td height="100"></td></tr>
                        <tr><td height="100"></td></tr>
                        <tr>
                            <td height="100" v-if="finals" bgcolor="#f1ffe6">
                                {{finals.team_name}} ({{finals.division_name}}) 
                                <br>
                                {{finals.oponent_name}} ({{finals.op_division_name}})
                                <br>
                                {{finals.winner_id ? (finals.winner_id === finals.team_id ? '1:0' : '0:1') : '-'}}
                            </td>
                            <td height="100" v-else></td>
                        </tr>
                        <tr><td height="100"></td></tr>
                        <tr>
                            <td height="100" v-if="loser_finals">
                                {{loser_finals.team_name}} ({{loser_finals.division_name}}) 
                                <br>
                                {{loser_finals.oponent_name}} ({{loser_finals.op_division_name}})
                                <br>
                                {{loser_finals.winner_id ? (loser_finals.winner_id === loser_finals.team_id ? '1:0' : '0:1') : '-'}}
                            </td>
                            <td height="100" v-else></td>
                        </tr>
                        <tr><td height="100"></td></tr>
                        <tr><td height="100"></td></tr>
                        <tr><td height="100"></td></tr>
                    </tbody>
                </table>
            </td>
            </tr>
            </table>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: [
            'divisions',
            'playoffs',
            'semis',
            'loser_finals',
            'finals',
            'csrf'
        ],
    }
</script>
