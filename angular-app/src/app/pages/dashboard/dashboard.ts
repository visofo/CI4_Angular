import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { StatsWidget } from './components/statswidget';
import { RecentSalesWidget } from './components/recentsaleswidget';
import { BestSellingWidget } from './components/bestsellingwidget';
import { RevenueStreamWidget } from './components/revenuestreamwidget';
import { NotificationsWidget } from './components/notificationswidget';
import { CommonModule } from '@angular/common';
import { environment } from '../../../environments/environment';

@Component({
    selector: 'app-dashboard',
    standalone: true,
    imports: [CommonModule, StatsWidget, RecentSalesWidget, BestSellingWidget, RevenueStreamWidget, NotificationsWidget],
    template: `
    <h1>{{ title }}</h1>
    <p>Data from API: {{ data | json }}</p>
        <!-- <div class="grid grid-cols-12 gap-8">
            <app-stats-widget class="contents"></app-stats-widget>
            <div class="col-span-12 xl:col-span-6">
                <app-recent-sales-widget></app-recent-sales-widget>
                <app-best-selling-widget></app-best-selling-widget>
            </div>
            <div class="col-span-12 xl:col-span-6">
                <app-revenue-stream-widget></app-revenue-stream-widget>
                <app-notifications-widget></app-notifications-widget>
            </div>
        </div> -->
    `
})
export class Dashboard  implements OnInit {
    title = 'angular-app';
    data: any;


    constructor(private http: HttpClient) {}

    ngOnInit(): void {
        this.http.get(environment.apiUrl + '/api/test')  // Adapte a rota da sua API
            .subscribe(response => {
                this.data = response;
                console.log(this.data);
            });
    }
}