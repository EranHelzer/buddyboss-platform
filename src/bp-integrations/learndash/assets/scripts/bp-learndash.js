/* global BP_LD_REPORTS_DATA */
(function($) {
	var BP_LD_Report = {
		$report_tables  : null,
		$report_selects : null,

		init: function() {
			this.$report_tables = jQuery( '.bp_ld_report_table' );

			this.fetch_table_data();

			$( '.bp-ld-reports-progress-bar' ).loading();

			$( '.admin-show-all' ).DataTable(
				{
					searching    : false,
					lengthChange : false,
					info         : false
				}
			);

			var dropDownUser = $( '.bp-learndash-reports-filters-form .bp-learndash-reports-filters select[name="user"]' );
			var dropDownStep = $( '.bp-learndash-reports-filters-form .bp-learndash-reports-filters select[name="step"]' );
			if ( dropDownUser.length ) {
				if ( '' === dropDownUser.val() ) {
					dropDownStep.prop( 'disabled', true );
				}
				$( dropDownUser ).on(
					'change',
					function() {
						if ( '' === $( this ).val() ) {
							dropDownStep.prop( 'disabled', true );
							dropDownStep.prop( 'disabled', true );
							dropDownStep.val( 'all' );
						} else {
							dropDownStep.prop( 'disabled', false );
						}

					}
				);
			}
		},

		fetch_table_data: function() {
			this.$report_tables.each( this.fetch_data.bind( this ) );
		},

		fetch_data: function( i, table ) {
			var self    = this;
			var type    = $( '[data-report-filter="step"]' ).val();
			var columns = BP_LD_REPORTS_DATA.table_columns[type];

			var args = {
				// data: response.data.results,
				columns      : this.adjustTableColumns( columns, table ),
				processing   : true,
				serverSide   : true,
				searching    : false,
				lengthChange : false,
				info         : false,
				pageLength   : BP_LD_REPORTS_DATA.config.perpage,
				language     : {
					processing : BP_LD_REPORTS_DATA.text.processing,
					emptyTable : BP_LD_REPORTS_DATA.text.emptyTable,
					paginate: {
						first    : BP_LD_REPORTS_DATA.text.paginate_first,
						last     : BP_LD_REPORTS_DATA.text.paginate_last,
						next     : BP_LD_REPORTS_DATA.text.paginate_next,
						previous : BP_LD_REPORTS_DATA.text.paginate_previous
					}
				},
				ajax: {
					url  : BP_LD_REPORTS_DATA.ajax_url,
					type : 'POST',
					data : function(d) {
						$( '[data-report-filter]' ).each(
							function() {
								var name = $( this ).data( 'report-filter' );
								d[name]  = $( this ).val();
							}
						);

						d.nonce     = BP_LD_REPORTS_DATA.nonce;
						d.action    = 'bp_ld_group_get_reports';
						d.group     = BP_LD_REPORTS_DATA.current_group;
						d.completed = $( table ).data( 'completed' ) ? 1 : 0;
						d.display   = true;
					}
				}
			};

			$( table )
				.on(
					'xhr.dt',
					function(e, settings, json) {
						if (json.data.length > 0) {
							$( e.target ).closest( '.bp_ld_report_table_wrapper' ).removeClass( 'no-data hidden' ).addClass( 'has-data' );
						} else {
							$( e.target ).closest( '.bp_ld_report_table_wrapper' ).removeClass( 'has-data' ).addClass( 'no-data hidden' );
						}

						$( e.target ).data( 'data_length', json.data.length );

						var emptyTables = 0;
						self.$report_tables.each(
							function() {
								if ($( this ).data( 'data_length' ) == 0) {
									emptyTables ++;
								}
							}
						);

						if (emptyTables == self.$report_tables.length) {
							$( '.ld-report-export-csv, .ld-report-no-data' ).removeClass( 'has-data' ).addClass( 'no-data hidden' );
						} else {
							$( '.ld-report-export-csv, .ld-report-no-data' ).removeClass( 'no-data hidden' ).addClass( 'has-data' );
						}
					}
				)
				.DataTable( args );
		},

		adjustTableColumns: function(columns, table) {
			var removedKey = $( table ).data( 'completed' ) ? 'updated_date' : 'completion_date';
			var newColumns = [];

			$( columns ).each(
				function(i, column) {
					if (column.name != removedKey) {
						newColumns.push( column );
					}
				}
			);

			return newColumns;
		},

		prepareExport: function(e) {
			e.preventDefault();
			var $target = $( e.target );

			// if it's already fetched, then just download it
			if ($target.data( 'exported' )) {
				window.location.href = $target.data( 'export_url' );
				return false;
			}

			var export_args = {
				nonce   : BP_LD_REPORTS_DATA.nonce,
				action  : 'bp_ld_group_export_reports',
				group   : BP_LD_REPORTS_DATA.current_group,
				'export'  : true
			};

			$( '[data-report-filter]' ).each(
				function() {
					var name          = $( this ).data( 'report-filter' );
					export_args[name] = $( this ).val();
				}
			);

			$target.data( 'export_args', export_args );
			BP_LD_Report.startExport( $target );
		},

		startExport: function($target) {
			var self        = this;
			var export_args = $target.data( 'export_args' );
			$target.prop( 'disabled', true );

			$.post(
				BP_LD_REPORTS_DATA.ajax_url,
				export_args,
				function(data) {
					$target.prop( 'disabled', false );
					if ( ! data.success) {
						$( '.export-indicator' ).text( BP_LD_REPORTS_DATA.text.export_failed );
						return;
					}
					//$target.data( 'exported', true );
					//$target.data( 'export_url', data.data.url );
					window.location.href = data.data.url;
					$( '.export-indicator' ).hide();
				},
				'json'
			);
		}
	};

	$.fn.dataTable.ext.classes.sPageButton = 'button';

	$(
		function() {
			BP_LD_Report.init();
			$( '.ld-report-export-csv' ).on( 'click', BP_LD_Report.prepareExport );
			window.history.replaceState( null, null, window.location.pathname );
		}
	);
})( jQuery );
